<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $rooms = Room::with('roomTenants')
            ->when($search, function ($query, $search) {
                $query->where('room_number', 'like', '%' . $search . '%');
            })
            ->get();

        return inertia('Admin/Rooms/Index', [
            'rooms' => $rooms,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return inertia('Admin/Rooms/AddRoom');
    }

    public function edit(Room $room)
    {
        return inertia('Admin/Rooms/EditRoom', [
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
        $tenantsWithoutRoom = Tenant::whereDoesntHave('roomTenants')->with('user')->get();

        $room->load([
            'roomTenants.tenant.user',
            'roomTenants.payee.user'
        ]);
        return inertia('Admin/Rooms/ShowRoom', [
            'room' => $room,
            'tenants' => $tenantsWithoutRoom,
        ]);
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
