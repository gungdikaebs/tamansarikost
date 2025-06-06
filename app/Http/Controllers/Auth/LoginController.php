<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return inertia('Auth/Login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'auth' => 'Username atau password salah',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();

        // Redirect berdasarkan role
        $user = Auth::user();

        if ($user->role === 'admin')
            return redirect()->intended('/dashboard/admin');
        elseif ($user->role === 'penghuni') {
            return redirect()->intended('/dashboard/penghuni');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
