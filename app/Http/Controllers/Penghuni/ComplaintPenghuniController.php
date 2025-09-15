<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Tenant;
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
        $tenant = Auth::user()->tenant->id;

        return inertia('Penghuni/Complaint/Create', [
            'tenant' => $tenant
        ]);
    }
    function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|string|in:pending,resolved,closed',
            'tenant_id' => 'required|exists:tenants,id'
        ]);

        $complaint = new Complaint($validated);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('complaint_photos', 'public');
            $complaint->image = $path;
        }

        $complaint->save();

        return redirect()->route('penghuni.complaint');
    }
}
