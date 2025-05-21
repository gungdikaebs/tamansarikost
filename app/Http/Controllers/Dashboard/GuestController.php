<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        return inertia('Dashboard/DashboardGuest');
    }
}
