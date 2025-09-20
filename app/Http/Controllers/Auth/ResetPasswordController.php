<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;


class ResetPasswordController extends Controller
{
    public function forgotPasswordForm()
    {
        return inertia(
            'Auth/ForgotPassword',
            [
                'status' => session('status'),
            ]
        );
    }
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert([
            'email' => $request->email
        ], [
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $resetLink = url('/reset-password/' . $token);

        // Kirim email (Mailtrap)
        Mail::raw("Klik link berikut untuk reset password: $resetLink", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Reset Password Link');
        });

        return back()->with('status', 'Link reset password telah dikirim ke email Anda.');
    }

    public function showResetForm($token)
    {
        return inertia('Auth/ResetPassword', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8'
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Token tidak valid atau telah kadaluarsa.']);
        }

        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Password berhasil diubah!');
    }
}
