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

        // Tidak perlu mengambil oldStatus di sini lagi jika logika akan di Observer
        // $oldStatus = $payment->payment_status;

        $validated = $request->validate([
            // ... validasi seperti sebelumnya
            'room_tenant_id' => 'required|exists:room_tenants,id',
            'amount'         => 'required|numeric|min:0',
            'payment_date'   => 'nullable|date',
            'payment_status' => 'nullable|in:unpaid,pending,confirmed,failed',
            'payment_method' => 'nullable|string|max:255',
            'billing_period' => 'required|date',
            'penalty_fee'    => 'nullable|numeric|min:0',
            'payment_photo'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $payment->fill($validated);

        if ($request->hasFile('payment_photo')) {
            if ($payment->payment_photo) {
                Storage::disk('public')->delete($payment->payment_photo);
            }
            $payment->payment_photo = $request->file('payment_photo')
                ->store('payment_photos', 'public');
        }

        $payment->save(); // Observer akan terpicu di sini!

        // Notifikasi flash message terkait pembuatan pembayaran baru bisa juga dipindahkan ke Observer
        // atau disesuaikan jika notifikasi ingin muncul di controller (tapi Observer akan lebih "benar")
        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.'); // Atau sesuaikan pesan
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
        $validated = $request->validate([
            'payment_status' => 'required|in:unpaid,pending,confirmed,failed',
            // 'payment_id' => 'nullable|integer', // Jika ini tidak digunakan, bisa dihapus
        ]);

        $payment->payment_status = $validated['payment_status'];
        $payment->save(); // Observer akan terpicu di sini!

        // Logika pembuatan pembayaran baru akan ditangani oleh Observer setelah 'confirmed'
        // Jadi bagian if ($validated['payment_status'] === 'confirmed') bisa dihapus
        return redirect()->route('payments.index')
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
