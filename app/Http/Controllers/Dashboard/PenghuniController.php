<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenghuniController extends Controller
{
    public function index()
    {
        $tenant = Auth::user()->tenant->with('payee')->first();
        $rooms = Room::whereHas('roomTenants', function ($q) use ($tenant) {
            $q->where('tenant_id', $tenant->id);
        })->get();
        return inertia('Dashboard/DashboardPenghuni', [
            'rooms' => $rooms,
            'tenant' => $tenant,
        ]);
    }
}
