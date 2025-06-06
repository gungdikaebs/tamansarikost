<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenghuniController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 'available')->get();
        return inertia('Dashboard/DashboardPenghuni', [
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
            'ktp_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        $ktp_path = $request->file('ktp_photo')->store('ktp_photos', 'public');
        $tenant = Tenant::create([
            'user_id' => Auth::id(),
            'fullname' => $validated['fullname'],
            'ktp_photo' => $ktp_path,
        ]);

        return redirect()->route('register.roomTenant', ['room_id' => session('selected_room_id')])->with('success', 'Tenant registered successfully.');
    }

    public function createRoomTenant()
    {
        $roomId = session('selected_room_id');
        $room = Room::find($roomId);
        if (!$room) {
            return redirect()->route('dashboard')->with('error', 'Room not found.');
        }
        return inertia('Guest/RegisterRoomTenant', [
            'room' => $room,
            'user' => Auth::user(),
        ]);
    }
}
