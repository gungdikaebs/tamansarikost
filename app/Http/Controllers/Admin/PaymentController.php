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
    public function index()
    {
        $payments = Payment::with([
            'roomTenant.tenant',
            'roomTenant.payee.user',
            'roomTenant.room'
        ])->get();
        return inertia('Payments/Index', [
            'payments' => $payments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roomTenants = RoomTenant::with('tenant', 'payee', 'room',)->get();
        $uniqueRoomTenants = $roomTenants->unique('payee_id')->values();


        return inertia('Payments/AddPayment', [
            'roomTenants' => $uniqueRoomTenants,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_tenant_id' => 'required|exists:room_tenants,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
            'payment_status' => 'nullable|in:pending,confirmed,failed',
            'payment_method' => 'nullable|string|max:255',
            'billing_period' => 'required|date',
            'penalty_fee' => 'nullable|numeric|min:0',
            'payment_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $payment = new Payment($validated);
        if ($request->hasFile('payment_photo')) {
            $payment->payment_photo = $request->file('payment_photo')->store('payments', 'public');
        }
        $payment->save();

        return redirect()->route('payments.index')
            ->with('success', 'Payment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::with([
            'roomTenant.tenant',
            'roomTenant.payee.user',
            'roomTenant.room'
        ])->findOrFail($id);

        return inertia('Payments/ShowPayment', [
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

        return inertia('Payments/EditPayment', [
            'payment' => $payment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payment = Payment::findOrFail($id);

        $validated = $request->validate([
            'room_tenant_id' => 'required|exists:room_tenants,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
            'payment_status' => 'nullable|in:pending,confirmed,failed',
            'payment_method' => 'nullable|string|max:255',
            'billing_period' => 'required|date',
            'penalty_fee' => 'nullable|numeric|min:0',
            'payment_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $payment->fill($validated);

        if ($request->hasFile('payment_photo')) {
            $payment->payment_photo = $request->file('payment_photo')->store('payments', 'public');
        }
        $payment->save();

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

        return inertia('Payments/Index')
            ->with('success', 'Payment deleted successfully.');
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        // Validasi input di awal
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,confirmed,failed',
            'payment_id' => 'nullable|integer', // jika ingin menerima payment_id dari frontend
        ]);

        // Update status pembayaran
        $payment->payment_status = $validated['payment_status'];
        $payment->save();

        // Jika status menjadi 'confirmed', buat pembayaran baru untuk periode berikutnya
        if ($validated['payment_status'] === 'confirmed') {
            $roomTenant = RoomTenant::with('tenant', 'room')->findOrFail($payment->room_tenant_id);

            $currentBillingPeriod = Carbon::parse($payment->billing_period);
            $newPayment = new Payment();
            $newPayment->room_tenant_id = $roomTenant->id;
            $newPayment->amount = $roomTenant->room->price;
            $newPayment->payment_date = null;
            $newPayment->payment_status = null;
            $newPayment->payment_method = null;
            $newPayment->billing_period = $currentBillingPeriod->addMonth();
            $newPayment->penalty_fee = 0;
            $newPayment->payment_photo = null;
            $newPayment->save();

            return redirect()->back()
                ->with('success', 'Payment confirmed and new payment created for next billing period.');
        }
        return inertia('Payments/Index')
            ->with('success', 'Payment status updated successfully.');
    }
}
