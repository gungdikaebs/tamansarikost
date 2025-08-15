<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomTenant;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomTenantController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'tenant_id' => 'required|exists:tenants,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
            'payee_id' => 'nullable|exists:tenants,id',
        ]);

        // Create the RoomTenant record
        RoomTenant::create($validated);

        // Update the room's status to 'occupied'
        $room = Room::findOrFail($validated['room_id']);
        $room->status = 'occupied';
        $room->save();

        return redirect()->route('rooms.show', $validated['room_id'])->with('success', 'Room Tenant created successfully.');
    }
    public function update(Request $request, RoomTenant $roomTenant)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        // Update the RoomTenant record
        $roomTenant->update($validated);

        // If status is active, ensure the room is marked as occupied
        if ($validated['status'] === 'active') {
            $room = Room::findOrFail($roomTenant->room_id);
            $room->status = 'occupied';
            $room->save();
        }

        return redirect()->route('rooms.show', $roomTenant->room_id)->with('success', 'Room Tenant updated successfully.');
    }

    public function destroy(string $id)
    {
        $roomTenant = RoomTenant::findOrFail($id);
        $roomId = $roomTenant->room_id;

        if ($roomTenant->status === 'active') {
            $room = Room::findOrFail($roomId);
            $room->status = 'available';
            $room->save();
        }

        $roomTenant->delete();

        return redirect()->route('rooms.show', $roomId)->with('success', 'Room Tenant deleted successfully.');
    }
}
