<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Payment;
use App\Models\User;



class PaymentPenghuniController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        // Connect Ke tenant
        $tenant = $user->tenant()->with('roomTenants.payments')->first();
        if (!$tenant) {
            return Inertia::render('Penghuni/Payment/Index', [
                'user' => $user,
                'payments' => [],
            ]);
        }
        $payments = $tenant->roomTenants
            ->pluck('payments')  // ngambil semua collection payment dari masing-masing roomTenant
            ->flatten()          // jadikan 1 dimensi list payment
            ->sortByDesc('created_at')  // opsional: urutkan terbaru dulu
            ->values();          // reset index

        return Inertia::render('Penghuni/Payment/Index', [
            'payments' => $payments,
        ]);
    }

    public function submitPayment(Request $request, $id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return redirect()->back()->with('error', 'Payment not found');
        }


        return Inertia::render('Penghuni/Payment/SubmitPayment', [
            'payment' => $payment,
        ]);
    }

    public function updatePayment(Request $request)
    {
        $validated = $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string|max:255',
            'payment_status' => 'nullable|in:unpaid,pending,confirmed,failed',
            'billing_period' => 'nullable|string|max:255',
            'penalty_fee' => 'nullable|numeric|min:0',
            'payment_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $payment = Payment::find($validated['payment_id']);
        if (!$payment) {
            return redirect()->back()->with('error', 'Payment not found');
        }
        // store photo
        if ($request->hasFile('payment_photo')) {
            $path = $request->file('payment_photo')->store('payment_photos', 'public');
            $validated['payment_photo'] = $path;
        }

        $payment->update($validated);

        return redirect()->route('penghuni.payment')->with('success', 'Payment updated successfully');
    }

    public function showPaymentForm(Request $request)
    {
        $payment = Payment::find($request->id);
        if (!$payment) {
            return redirect()->back()->with('error', 'Payment not found');
        }

        return Inertia::render('Penghuni/Payment/ShowPayment', [
            'payment' => $payment->setAttribute('payment_photo', $payment->payment_photo ? asset('storage/' . $payment->payment_photo) : null),
        ]);
    }
}
