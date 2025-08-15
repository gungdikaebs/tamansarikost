<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $complaint = Complaint::with(['tenant'])
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->get();

        return inertia('Admin/Complaints/Index', [
            'complaints' => $complaint,
            'search' => $search
        ]);
    }

    public function show(Complaint $complaint)
    {
        return inertia('Admin/Complaints/ShowComplaint', [
            'complaint' => $complaint->load('tenant', 'tenant.roomTenants.room')
        ]);
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,resolved,closed',
        ]);

        $complaint->update($validated);

        return redirect()->route('complaints.index')->with('success', 'Complaint status updated successfully.');
    }

    public function destroy(Complaint $complaint)
    {
        $complaint->delete();

        return redirect()->route('complaints.index')->with('success', 'Complaint deleted successfully.');
    }
}
