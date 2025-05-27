<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 'available')->get();
        return inertia('Dashboard/DashboardGuest', [
            'rooms' => $rooms,

        ]);
    }
}
