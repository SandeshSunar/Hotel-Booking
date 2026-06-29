<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{
    // Show register page
    public function showRegister()
    {
        return redirect()->route('home')->with('open_auth_modal', 'register');
    }

    // Handle register request
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:10',
                'password' => 'required|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validator->errors());
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'usertype' => 'user', // Default new users are normal users
            ]);

            return redirect()->route('home')
                ->with('open_auth_modal', 'login')
                ->with('success', 'Account created successfully. Please login.');
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    // Show login page
    public function showLogin()
    {
        if (request()->routeIs('admin.login')) {
            return view('auth.admin-login');
        }

        return redirect()->route('home')->with('open_auth_modal', 'login');
    }

    // Handle login request
    public function login(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator->errors());
        }

        // Attempt login
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect based on usertype
            if ($user->usertype === 'admin') {
                return redirect()->route('admin.dashboard.index');
            } else {
                return redirect()->route('home'); // ✅ Correct route for normal users
            }
        }

        return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')
            ->with('open_auth_modal', 'login')
            ->with('success', 'Logged out successfully.');
    }
} 