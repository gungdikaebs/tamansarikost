<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 'available')->get();
        return inertia('Room/Index', [
            'rooms' => $rooms
        ]);
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        return inertia('Room/Show', [
            'room' => $room
        ]);
    }
}
