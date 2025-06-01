<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::with(['roomTenants', 'user'])->get()->map(function ($tenant) {
            $tenant->ktp_photo_url = $tenant->ktp_photo ? asset('storage/' . $tenant->ktp_photo) : null;
            return $tenant;
        });
        return inertia('Tenants/Index', [
            'tenants' => $tenants,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'penghuni')->whereDoesntHave('tenant')->get();
        return inertia(
            'Tenants/AddTenant',
            [
                'users' => $users,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'fullname' => 'required|string|max:255',
            'ktp_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $ktp_path = $request->file('ktp_photo')->store('ktp_photos', 'public');

        $tenant = Tenant::create([
            'user_id' => $validated['user_id'],
            'fullname' => $validated['fullname'],
            'ktp_photo' => $ktp_path,

        ]);

        return redirect()->route('tenants.index')->with('success', 'Tenant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        $users = User::where('role', 'penghuni')
            ->get();
        return inertia('Tenants/EditTenant', [
            'tenant' => $tenant->load('user'),
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'fullname' => 'required|string|max:255',
            'ktp_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('ktp_photo')) {
            $file = $request->file('ktp_photo');
            $path = $file->store('ktp_photos', 'public');
            $validated['ktp_photo'] = $path;
        }

        $tenant->update($validated);


        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        //
    }
}
