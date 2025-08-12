<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Payment;
use App\Models\User;



class PaymentHistory extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        // Connect Ke tenant
        $tenant = $user->tenant()->with('roomTenants.payments')->first();
        if (!$tenant) {
            return Inertia::render('Penghuni/PaymentHistory', [
                'user' => $user,
                'payments' => [],
            ]);
        }
        $payments = $tenant->roomTenants
            ->pluck('payments')  // ngambil semua collection payment dari masing-masing roomTenant
            ->flatten()          // jadikan 1 dimensi list payment
            ->sortByDesc('created_at')  // opsional: urutkan terbaru dulu
            ->values();          // reset index

        return Inertia::render('Penghuni/PaymentHistory', [
            'payments' => $payments,
        ]);
    }
}
