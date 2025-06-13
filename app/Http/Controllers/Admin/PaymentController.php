<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\RoomTenant;

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
        $roomTenants = RoomTenant::with('tenant', 'room', 'payment')->get();
        return inertia('Payments/AddPayment', [
            'roomTenants' => $roomTenants,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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

            $currentBillingPeriod = \Carbon\Carbon::parse($payment->billing_period);
            $newPayment = new Payment();
            $newPayment->room_tenant_id = $roomTenant->id;
            $newPayment->amount = $roomTenant->room->price;
            $newPayment->payment_date = null;
            $newPayment->payment_status = null;
            $newPayment->payment_method = null;
            $newPayment->billing_period = $currentBillingPeriod->addMonth()->format('d-m-Y');
            $newPayment->penalty_fee = 0;
            $newPayment->payment_photo = null;
            $newPayment->save();

            return redirect()->back()
                ->with('success', 'Payment confirmed and new payment created for next billing period.');
        }
        return redirect()->route('payments.index')
            ->with('success', 'Payment status updated successfully.');
    }
}
