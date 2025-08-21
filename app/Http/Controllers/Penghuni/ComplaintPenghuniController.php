<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class ComplaintPenghuniController extends Controller
{
    function index()
    {
        $complaints = Auth::user()->tenant->complaints()->latest()->get();
        return inertia('Penghuni/Complaint/Index', [
            'complaints' => $complaints
        ]);
    }

    function show($id)
    {
        $complaint = Complaint::findOrFail($id);
        return inertia('Penghuni/Complaint/Show', [
            'complaint' => $complaint
        ]);
    }

    function create()
    {
        return inertia('Penghuni/Complaint/Create');
    }
    function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $complaint = new Complaint($validated);
        $complaint->tenant_id = Auth::id();
        $complaint->save();

        return redirect()->route('penghuni.complaints');
    }
}
