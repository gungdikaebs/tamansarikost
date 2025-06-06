<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomTenant;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PenghuniController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tenant = Tenant::with('roomTenants.room', 'roomTenants.payee')->where('user_id', $user->id)->first();

        if ($tenant) {
            $roomTenantsData = $tenant->roomTenants->map(function ($rt) {
                return [
                    'id' => $rt->id,
                    'room' => $rt->room,
                    'payee_name' => $rt->payee ? $rt->payee->fullname : null,
                    'start_date' => $rt->start_date,
                    'end_date' => $rt->end_date,
                    'status' => $rt->status,
                ];
            });
            // Jika tenant ada, kirim tenant lengkap dengan relasi roomTenants dan kamar
            return inertia('Dashboard/DashboardPenghuni', [
                'tenant' => $tenant,
                'roomTenants' => $roomTenantsData,
                'rooms' => $tenant->roomTenants->map(function ($rt) {
                    return $rt->room; // mengirim kamar yang terkait
                }),
            ]);
        } else {
            // Belum ada tenant, kirim daftar kamar yang tersedia
            $availableRooms = Room::where('status', 'available')->get();
            return inertia('Dashboard/DashboardPenghuni', [
                'tenant' => null,
                'roomTenants' => [],
                'rooms' => $availableRooms,
            ]);
        }
    }

    public function createTenant()
    {
        $roomId = request()->query('room_id');

        if (!$roomId) {
            return redirect()->route('dashboard.penghuni')->with('error', 'Room ID is required for booking.');
        }

        // Simpan room id ke session untuk dipakai di storeTenant dan createRoomTenant
        session(['selected_room_id' => $roomId]);

        return inertia('Penghuni/RegisterTenant', [
            'room_id' => $roomId,
            'user' => Auth::user(),
        ]);
    }


    public function storeTenant(Request $request)
    {
        $roomId = session('selected_room_id');
        if (!$roomId) {
            return redirect()->route('dashboard.penghuni')->with('error', 'Room ID is missing in the session.');
        }

        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'ktp_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $userId = Auth::id(); // Ambil user_id dari user yang login

        // Cek tenant sudah ada berdasarkan user_id
        $existingTenant = Tenant::where('user_id', $userId)->first();
        if ($existingTenant) {
            return redirect()->back()->with('error', 'You already have a tenant registered.');
        }

        if ($request->hasFile('ktp_photo')) {
            $filePath = $request->file('ktp_photo')->store('ktp_photos', 'public');
        } else {
            return back()->withErrors(['ktp_photo' => 'KTP photo is required']);
        }

        // Simpan tenant baru
        $tenant = new Tenant();
        $tenant->user_id = $userId;
        $tenant->fullname = $validatedData['fullname'];
        $tenant->ktp_photo = $filePath;
        $tenant->save();

        // Data untuk insert ke pivot room_tenant
        $roomTenant = new RoomTenant();
        $roomTenant->room_id = $roomId;
        $roomTenant->tenant_id = $tenant->id;
        $roomTenant->start_date = Carbon::now()->toDateString();
        $roomTenant->end_date = null;
        $roomTenant->status = 'active';
        $roomTenant->payee_id = $tenant->id;
        $roomTenant->save();

        // Update status kamar menjadi 'occupied'
        $room = Room::findOrFail($roomId);
        $room->status = 'occupied';
        $room->save();

        // Bersihkan session
        session()->forget('selected_room_id');

        return redirect()->route('dashboard.penghuni')->with('success', 'Tenant registered successfully and room booked.');
    }
}
