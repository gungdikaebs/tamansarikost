<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $sortBy = $request->input('sort_by', '');
        $sortOrder = $request->input('sort_order', 'asc');

        $users = User::when($search, function ($query, $search) {
            $query->where('username', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })
            ->when($sortBy, function ($query, $sortBy) use ($sortOrder) {
                // Validasi kolom yg boleh di sort, untuk keamanan
                $allowedSorts = ['role', 'username', 'email'];
                if (in_array($sortBy, $allowedSorts)) {
                    $query->orderBy($sortBy, $sortOrder);
                }
            })
            ->get();

        return inertia('Admin/Users/Index', [
            'users' => $users,
            'search' => $search,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Users/AddUser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|in:admin,penghuni',
            'phone' => [
                'required',
                'regex:/^(\+62|62|0)[0-9]{6,15}$/'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[0-9!@#$%^&*(),.?":{}|<>]/',
            ]
        ]);
        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
        ]);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('tenant.roomTenants.room');
        // get tenant's KTP photo URL
        $user->tenant->ktp_photo = $user->tenant->ktp_photo ? asset('storage/' . $user->tenant->ktp_photo) : null;
        // get profile picture URL
        // $user->profile_picture = $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('images/default-profile.png');
        return inertia('Admin/Users/ShowUser', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return inertia('Admin/Users/EditUser', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,penghuni',
            'phone' => [
                'required',
                'regex:/^(\+62|62|0)[0-9]{6,15}$/'
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/[0-9!@#$%^&*(),.?":{}|<>]/',
            ]
        ]);

        $user->update([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'phone' => $validated['phone'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
