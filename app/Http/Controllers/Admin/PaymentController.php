<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\RoomTenant;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $payments = Payment::with([
            'roomTenant.tenant',
            'roomTenant.payee.user',
            'roomTenant.room'
        ])
            ->when($search, function ($query, $search) {
                $query->whereHas('roomTenant.tenant', function ($q) use ($search) {
                    $q->where('fullname', 'like', '%' . $search . '%');
                })
                    ->orWhere('amount', 'like', '%' . $search . '%')
                    ->orWhere('payment_status', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc') // urutkan berdasarkan data terbaru
            ->paginate(10)
            ->withQueryString();

        return inertia('Admin/Payments/Index', [
            'payments' => $payments,
            'search' => $search,
            'flash' => $request->session()->get('flash', []),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomTenants = RoomTenant::with('tenant', 'payee', 'room',)->where('status', 'active')->get();
        $uniqueRoomTenants = $roomTenants->unique('payee_id')->values();

        return inertia('Admin/Payments/AddPayment', [
            'roomTenants' => $uniqueRoomTenants,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_tenant_id' => 'required|exists:room_tenants,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
            'payment_status' => 'nullable|in:unpaid,pending,confirmed,failed',
            'payment_method' => 'nullable|string|max:255',
            'billing_period' => 'required|date',
            'penalty_fee' => 'nullable|numeric|min:0',
            'payment_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $payment = new Payment($validated);
        if ($request->hasFile('payment_photo')) {
            $payment->payment_photo = $request->file('payment_photo')->store('payment_photos', 'public');
        }
        $payment->save();

        return redirect()->route('payments.index')
            ->with('success', 'Payment created successfully.');
    }

    public function show(string $id)
    {
        $payment = Payment::with([
            'roomTenant.tenant',
            'roomTenant.payee.user',
            'roomTenant.room'
        ])->find($id);

        if (!$payment) {
            return redirect()->route('payments.index')->with('error', 'Payment not found.');
        }

        return inertia('Admin/Payments/ShowPayment', [
            'payment' => $payment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::with([
            'roomTenant.tenant',
            'roomTenant.payee.user',
            'roomTenant.room'
        ])->findOrFail($id);

        return inertia('Admin/Payments/EditPayment', [
            'payment' => $payment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payment = Payment::findOrFail($id);

        // Ambil status lama sebelum di‑update
        $oldStatus = $payment->payment_status;

        // Validasi input
        $validated = $request->validate([
            'room_tenant_id' => 'required|exists:room_tenants,id',
            'amount'         => 'required|numeric|min:0',
            'payment_date'   => 'nullable|date',
            'payment_status' => 'nullable|in:unpaid,pending,confirmed,failed',
            'payment_method' => 'nullable|string|max:255',
            'billing_period' => 'required|date',
            'penalty_fee'    => 'nullable|numeric|min:0',
            'payment_photo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Isi atribut model dengan data yang divalidasi
        $payment->fill($validated);

        // Simpan foto bila ada
        if ($request->hasFile('payment_photo')) {
            // Hapus foto lama (opsional)
            if ($payment->payment_photo) {
                Storage::disk('public')->delete($payment->payment_photo);
            }
            $payment->payment_photo = $request->file('payment_photo')
                ->store('payment_photos', 'public');
        }

        // Simpan perubahan utama dulu
        $payment->save();

        // -------------------------------------------------
        // 1️⃣ Cek apakah status berubah menjadi confirmed (atau success)
        // -------------------------------------------------
        $newStatus = $payment->payment_status;
        $triggerStatus = 'confirmed'; // ganti ke 'success' bila memang ingin memakai kata itu

        if ($oldStatus !== $newStatus && $newStatus === $triggerStatus) {
            // -------------------------------------------------
            // 2️⃣ Buat pembayaran baru untuk periode berikutnya
            // -------------------------------------------------
            $roomTenant = RoomTenant::with('tenant', 'room')
                ->findOrFail($payment->room_tenant_id);

            // Billing period saat ini
            $currentBillingPeriod = Carbon::parse($payment->billing_period);
            // Tambah satu bulan untuk periode berikutnya (hanya tanggal, bulan, tahun)
            $nextBillingPeriod = $currentBillingPeriod->copy()->addMonth()->startOfDay()->format('Y-m-d');
            $newPayment = new Payment();
            $newPayment->room_tenant_id = $roomTenant->id;
            $newPayment->amount        = $roomTenant->room->price;
            $newPayment->payment_date  = null;
            $newPayment->payment_status = 'unpaid';
            $newPayment->payment_method = null;
            $newPayment->billing_period = $nextBillingPeriod;
            $newPayment->penalty_fee    = 0;
            $newPayment->payment_photo  = null;
            $newPayment->save();
            // -------------------------------------------------
            // Opsional: beri notifikasi bahwa data baru sudah dibuat
            // -------------------------------------------------
            $request->session()->flash('info', 'Pembayaran berhasil dikonfirmasi, pembayaran baru untuk periode berikutnya sudah dibuat.');
        }

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        if ($payment->payment_photo) {
            Storage::disk('public')->delete($payment->payment_photo);
        }
        $payment->delete();

        // Redirect ke halaman index dengan pesan sukses dan refresh data
        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        // Validasi input di awal
        $validated = $request->validate([
            'payment_status' => 'required|in:unpaid,pending,confirmed,failed',
            'payment_id' => 'nullable|integer', // jika ingin menerima payment_id dari frontend
        ]);

        // Update status pembayaran
        $payment->payment_status = $validated['payment_status'];
        $payment->save();

        // Jika status menjadi 'confirmed', buat pembayaran baru untuk periode berikutnya
        if ($validated['payment_status'] === 'confirmed') {
            $roomTenant = RoomTenant::with('tenant', 'room')->findOrFail($payment->room_tenant_id);

            $currentBillingPeriod = Carbon::parse($payment->billing_period);
            $nextBillingPeriod = $currentBillingPeriod->copy()->addMonth();
            $newPayment = new Payment();
            $newPayment->room_tenant_id = $roomTenant->id;
            $newPayment->amount = $roomTenant->room->price;
            $newPayment->payment_date = null;
            $newPayment->payment_status = 'unpaid';
            $newPayment->payment_method = null;
            $newPayment->billing_period = $nextBillingPeriod;
            $newPayment->penalty_fee = 0;
            $newPayment->payment_photo = null;
            $newPayment->save();

            return redirect()->back()
                ->with('success', 'Payment confirmed and new payment created for next billing period.');
        }
        return inertia('Admin/Payments/Index')
            ->with('success', 'Payment status updated successfully.');
    }
}
