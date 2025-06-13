<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

class PenghuniController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil tenant yang terkait dengan user
        $tenant = Tenant::with('roomTenants.room', 'roomTenants.payee')
            ->where('user_id', $user->id)
            ->first();

        if (!$tenant) {
            // User belum punya tenant, tampilkan kamar tersedia
            $availableRooms = Room::where('status', 'available')->get();
            return inertia('Dashboard/DashboardPenghuni', [
                'tenant' => null,
                'roomTenants' => [],
                'rooms' => $availableRooms,
            ]);
        }

        // Filter roomTenants yang punya payee_id == tenant id user
        $roomTenantsAsPayee = $tenant->roomTenants->filter(function ($roomTenant) use ($tenant) {
            return $roomTenant->payee_id == $tenant->id;
        });

        if ($roomTenantsAsPayee->isEmpty()) {
            // Tenant tidak bertanggung jawab bayar di room mana pun, tampilkan dashboard biasa
            return inertia('Dashboard/DashboardPenghuni', [
                'tenant' => $tenant,
                'roomTenants' => $tenant->roomTenants,
                'rooms' => $tenant->roomTenants->map(fn($rt) => $rt->room),
            ]);
        }

        // Cek apakah ada roomTenant dengan payment kosong untuk tenant sebagai payee
        foreach ($roomTenantsAsPayee as $roomTenant) {
            $roomTenant->load('payments');

            if ($roomTenant->payments->isEmpty()) {
                // Ada roomTenant belum bayar, redirect ke halaman register payment untuk roomTenant tersebut
                return redirect()->route('penghuni.register-payment', ['roomTenant' => $roomTenant->id])
                    ->with('info', 'Please complete your payment registration.');
            }
        }

        // Semua sudah bayar, tampilkan dashboard biasa
        return inertia('Dashboard/DashboardPenghuni', [
            'tenant' => $tenant,
            'roomTenants' => $tenant->roomTenants,
            'rooms' => $tenant->roomTenants->map(fn($rt) => $rt->room),
        ]);
    }
}
