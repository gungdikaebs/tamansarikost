<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Payment;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;



class AdminController extends Controller
{

    public function index()
    {
        $users = User::all();
        $payments = Payment::whereIn('status', ['pending', 'unpaid'])->get();
        $complaints = Complaint::where('status', 'pending')->get();
        return inertia('Dashboard/DashboardAdmin', [
            'users' => $users,
            'payments' => $payments,
            'complaints' => $complaints
        ]);
    }
}
