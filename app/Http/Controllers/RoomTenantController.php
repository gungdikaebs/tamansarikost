<?php

namespace App\Http\Controllers;

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

        $room = Room::findOrFail($validated['room_id']);
        $activeTenants = $room->roomTenants()->where('status', 'active')->count();

        if ($activeTenants >= 1) {
            $room->update(['status' => 'occupied']);
        }

        return redirect()->route('rooms.show', $validated['room_id'])->with('success', 'Room Tenant created successfully.');
    }

    public function destroy(string $id)
    {
        $roomTenant = RoomTenant::findOrFail($id);
        $roomId = $roomTenant->room_id;
        $roomTenant->delete();

        $room = Room::find($roomId);
        $activeTenants = $room->roomTenants()->where('status', 'active')->count();
        if ($activeTenants === 0) {
            $room->update(['status' => 'available']);
        }

        return redirect()->route('rooms.show', $roomId)->with('success', 'Room Tenant deleted successfully.');
    }
}
