<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $rooms = Room::with('roomTenants')->get();
        } elseif ($user->role === 'penghuni') {
            $tenant = $user->tenant;
            $rooms = Room::whereHas('roomTenants', function ($q) use ($tenant) {
                $q->where('tenant_id', $tenant->id);
            })->get();
        } elseif ($user->role === 'guest') {
            $rooms = Room::where('status', 'available')->get();
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return inertia('Rooms/Index', [
            'rooms' => $rooms,
            'role' => $user->role,
        ]);
    }
}
