<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    public function index()
    {
        return inertia('Dashboard/DashboardPenghuni');
    }
}
