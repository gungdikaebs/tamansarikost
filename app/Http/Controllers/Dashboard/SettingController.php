<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {

        $user = User::find(Auth::id());
        $profile_path = $user->profile_picture;
        if ($profile_path) {
            $user->profile_picture = asset('storage/' . $profile_path);
        } else {
            $user->profile_picture = null;
        }

        $tenant = $user->tenant;
        $ktp_path = $tenant ? $tenant->ktp_photo : null;
        if ($ktp_path) {
            $tenant->ktp_photo = asset('storage/' . $ktp_path);
        } else {
            $tenant->ktp_photo = null;
        }

        return inertia('Dashboard/Settings', [
            'user' => $user,
            'tenant' => $tenant
        ]);
    }
    public function updateUser(Request $request)
    {
        $user = User::find(Auth::id());

        $validated = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
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
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;

            // Hapus file lama jika ada
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
        }

        $user->update([
            'profile_picture' => $validated['profile_picture'] ?? $user->profile_picture,
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
        ]);

        return redirect()->route('dashboard.settings')->with('success', 'Profil pengguna berhasil diperbarui.');
    }

    public function updateTenant(Request $request)
    {
        $user = User::find(Auth::id());
        $tenant = $user->tenant;

        if (!$tenant) {
            return redirect()->route('dashboard.settings')->with('error', 'Anda bukan penghuni.');
        }

        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'ktp_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->hasFile('ktp_photo')) {
            $path = $request->file('ktp_photo')->store('ktp_photos', 'public');
            $validated['ktp_photo'] = $path;

            // Hapus file lama jika ada
            if ($tenant->ktp_photo) {
                Storage::disk('public')->delete($tenant->ktp_photo);
            }
        }
        $tenant->update([
            'fullname' => $validated['fullname'],
            'ktp_photo' => $validated['ktp_photo'] ?? $tenant->ktp_photo,
        ]);
        return redirect()->route('dashboard.settings')->with('success', 'Profil penghuni berhasil diperbarui.');
    }
}
