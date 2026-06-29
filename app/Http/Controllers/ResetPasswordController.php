<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    // Show reset password form
    public function showResetForm($token)
    {
        if (request()->routeIs('admin.password.reset')) {
            return view('auth.admin-reset-password', ['token' => $token]);
        }

        return view('auth.reset-password', ['token' => $token]);
    }

    // Handle password reset
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return back()->withErrors(['email' => __($status)]);
        }

        if ($request->routeIs('admin.password.update')) {
            return redirect()->route('admin.login')
                ->with('success', 'Password reset successful. You can login now.');
        }

        return redirect()->route('home')
            ->with('open_auth_modal', 'login')
            ->with('success', 'Password reset successful. You can login now.');
    }
}
