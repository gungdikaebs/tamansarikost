<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;          // pastikan pakai helper inertia()
use Illuminate\Support\Collection;

class PenghuniController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $user = Auth::user();

        // 1️⃣ Ambil tenant berserta roomTenants, room, payee, dan payments
        $tenant = Tenant::with([
            'roomTenants.room',
            'roomTenants.payee',
            'roomTenants.payments'   // <‑ eager load payments
        ])
            ->where('user_id', $user->id)
            ->first();

        // 2️⃣ Jika belum punya tenant → tampilkan kamar tersedia
        if (!$tenant) {
            $availableRooms = Room::where('status', 'available')->get();

            return Inertia::render('Dashboard/DashboardPenghuni', [
                'tenant'       => null,
                'roomTenants'  => [],
                'rooms'        => $availableRooms,
                'paymentHistory' => [],   // kosong
            ]);
        }

        // 3️⃣ Kumpulkan semua payment yang dimiliki tenant (baik sebagai payee maupun sebagai tenant)
        $paymentHistory = $tenant->roomTenants
            ->flatMap(function ($rt) {
                return $rt->payments;
            })
            ->sortByDesc('created_at')
            ->take(6)      // ambil 6 data terbaru
            ->values();    // reset index

        // 4️⃣ Filter roomTenants yang menjadi payee (untuk cek payment yang belum ada)
        $roomTenantsAsPayee = $tenant->roomTenants->filter(fn($rt) => $rt->payee_id == $tenant->id);

        // 5️⃣ Jika payee belum melunasi satupun roomTenant → redirect ke register‑payment
        foreach ($roomTenantsAsPayee as $rt) {
            if ($rt->payments->isEmpty()) {
                return redirect()
                    ->route('penghuni.register-payment', ['roomTenant' => $rt->id])
                    ->with('info', 'Please complete your payment registration.');
            }
        }

        // 6️⃣ Semua sudah bayar → tampilkan dashboard dengan riwayat payment
        return Inertia::render('Dashboard/DashboardPenghuni', [
            'tenant'         => $tenant,
            'roomTenants'    => $tenant->roomTenants,
            'rooms'          => $tenant->roomTenants->map(fn($rt) => $rt->room),
            'paymentHistory' => $paymentHistory,   // ← baru
=======
        $tenant = Auth::user()->tenant->with('payee')->first();
        $rooms = Room::whereHas('roomTenants', function ($q) use ($tenant) {
            $q->where('tenant_id', $tenant->id);
        })->get();
        return inertia('Dashboard/', [
            'rooms' => $rooms,
            'tenant' => $tenant,
>>>>>>> main
        ]);
    }
}
