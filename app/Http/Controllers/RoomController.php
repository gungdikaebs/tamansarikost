<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('roomTenants')->get();

        return inertia('Rooms/Index', [
            'rooms' => $rooms,
        ]);
    }

    public function create()
    {
        return inertia('Rooms/AddRoom');
    }

    public function edit(Room $room)
    {
        return inertia('Rooms/EditRoom', [
            'room' => $room,
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        Room::create($validated);
        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number,' . $room->id . ',id',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        $room->update($validated);
        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function show(Room $room)
    {
        $room->load('roomTenants.tenant.user');
        return inertia('Rooms/ShowRoom', [
            'room' => $room,
        ]);
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
