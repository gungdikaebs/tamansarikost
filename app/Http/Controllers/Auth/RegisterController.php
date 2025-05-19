<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return inertia('Auth/Register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'phone' => [
                'required',
                'regex:/^(\+62|62|0)[0-9]{6,15}$/'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[0-9!@#$%^&*(),.?":{}|<>]/',
                'confirmed'
            ]
        ]);

        // Create the user
        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'email_verified_at' => now(),
            'role' => 'guest', // Default role
        ]);

        Auth::login($user);
        return redirect()->intended('/');
    }
}
