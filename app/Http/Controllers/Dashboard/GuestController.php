<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GuestController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 'available')->get();
        return inertia('Dashboard/DashboardGuest', [
            'rooms' => $rooms,

        ]);
    }

    public function createTenant()
    {
        $rooms = Room::where('status', 'available')->get();
        return inertia('Guest/RegisterTenant', [    
            'room_id' => request()->query('room_id'),
            'user' => Auth::user(),
        ]);
    }
    public function storeTenant(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'ktp_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'room_id' => 'required|exists:rooms,id', // untuk keperluan booking lanjut
        ]);

        $ktp_path = $request->file('ktp_photo')->store('ktp_photos', 'public');
        $tenant = Tenant::create([
            'user_id' => Auth::id(),
            'fullname' => $validated['fullname'],
            'ktp_photo' => $ktp_path,
        ]);
        $user = User::find(Auth::id());
        if ($user) {
            $user->role = 'penghuni';
            $user->save();
        }

        return Inertia::location('/dashboard/tenants');
    }
}
