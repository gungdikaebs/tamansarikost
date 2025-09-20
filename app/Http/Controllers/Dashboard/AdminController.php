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

        // Chart Pie
        $month = now()->month;
        $year = now()->year;
        $income = Report::whereMonth('date', $month)->whereYear('date', $year)->where('type', 'income')->sum('amount');
        $outcome = Report::whereMonth('date', $month)->whereYear('date', $year)->where('type', 'outcome')->sum('amount');

        // Chart Line
        $trend = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->copy()->subMonths($i);
            $trend[] = [
                'label' => $date->format('M Y'),
                'income' => (float)Report::whereMonth('date', $date->month)->whereYear('date', $date->year)->where('type', 'income')->sum('amount'),
                'outcome' => (float)Report::whereMonth('date', $date->month)->whereYear('date', $date->year)->where('type', 'outcome')->sum('amount'),
            ];
        }

        return inertia('Dashboard/DashboardAdmin', [
            'users' => $users,
            'payments' => $payments,
            'complaints' => $complaints,
            'chart' => [
                'pie' => [
                    'income' => (float)$income,
                    'outcome' => (float)$outcome,
                ],
                'trend' => $trend,
            ],
        ]);
    }
}
