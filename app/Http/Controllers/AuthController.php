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
                    ->withErrors($validator->errors())
                    ->with('open_auth_modal', 'register');
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
            return redirect()->back()->withInput()->with('error', $e->getMessage())->with('open_auth_modal', 'register');
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
        // --- Rate Limiting: Check lockout ---
        $lockoutKey      = 'login_locked_until';
        $attemptsKey     = 'login_failed_attempts';
        $lockedUntil     = $request->session()->get($lockoutKey);

        if ($lockedUntil && now()->timestamp < $lockedUntil) {
            $remaining = $lockedUntil - now()->timestamp;
            return redirect()->back()
                ->withInput()
                ->with('open_auth_modal', 'login')
                ->with('login_locked', true)
                ->with('login_locked_seconds', $remaining)
                ->with('error', 'Too many failed attempts! Please wait ' . $remaining . ' second(s) before trying again.');
        }

        // Reset lockout state if the lockout period has expired
        if ($lockedUntil && now()->timestamp >= $lockedUntil) {
            $request->session()->forget([$lockoutKey, $attemptsKey]);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator->errors())
                ->with('open_auth_modal', 'login');
        }

        // Attempt login
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Successful login: clear rate-limit counters
            $request->session()->forget([$lockoutKey, $attemptsKey]);
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect based on usertype
            if ($user->usertype === 'admin') {
                return redirect()->route('admin.dashboard.index');
            } else {
                return redirect()->route('home');
            }
        }

        // --- Rate Limiting: Increment failed attempts ---
        $attempts = $request->session()->get($attemptsKey, 0) + 1;
        $request->session()->put($attemptsKey, $attempts);

        if ($attempts >= 3) {
            // Lock the account for 60 seconds
            $request->session()->put($lockoutKey, now()->timestamp + 60);
            $request->session()->put($attemptsKey, 0); // reset counter for next window
            return redirect()->back()
                ->withInput()
                ->with('open_auth_modal', 'login')
                ->with('login_locked', true)
                ->with('login_locked_seconds', 60)
                ->with('error', 'Too many failed attempts! Please wait 60 second(s) before trying again.');
        }

        $remaining = 3 - $attempts;
        return redirect()->back()
            ->withInput()
            ->with('error', 'Invalid email or password. ' . $remaining . ' attempt(s) remaining before lockout.')
            ->with('open_auth_modal', 'login');
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