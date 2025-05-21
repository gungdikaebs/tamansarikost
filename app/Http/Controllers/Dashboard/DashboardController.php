<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        } elseif ($user->role === 'penghuni')
            return redirect()->route('dashboard.penghuni');
        elseif ($user->role === 'guest') {
            return redirect()->route('dashboard.guest');
        }
        return redirect()->route('login')->with('error', 'Please login to access this page.');
    }
}
