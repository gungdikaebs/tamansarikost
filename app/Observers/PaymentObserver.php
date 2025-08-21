<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\Report;
use App\Models\RoomTenant;
use Illuminate\Support\Carbon;

class PaymentObserver
{
    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment)
    {
        // Cek apakah field payment_status berubah dan menjadi confirmed
        if ($payment->isDirty('payment_status') && $payment->payment_status === 'confirmed') {
            // Ambil data RoomTenant beserta room dan tenantnya, asumsikan relasi sudah ada
            $roomTenant = $payment->roomTenant;

            // Buat payment baru untuk periode berikutnya
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

            // Tambahkan data ke reports
            Report::create([
                'payment_id' => $payment->id,
                'amount' => $payment->amount,
                'type' => 'income',
                'description' => 'Pembayaran telah dikonfirmasi untuk periode ' . $payment->billing_period,
                'date' => Carbon::now(),
            ]);
        }
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment)
    {
        Report::where('payment_id', $payment->id)->delete();
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
