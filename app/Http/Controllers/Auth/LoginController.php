<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Login with throttle/rate-limit protection.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
            'remember' => ['nullable','boolean'],
        ]);

        $throttleKey = $this->throttleKey($request);

        // Allow 5 attempts per minute as a conservative starting point.
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => ["Too many login attempts. Try again in {$seconds} seconds."],
            ])->status(429);
        }

        $credentials = $request->only('email', 'password');
        $remember = (bool)$request->input('remember', false);

        if (Auth::attempt($credentials, $remember)) {
            // Clear throttle attempts on success
            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            // If email not verified, logout and ask for verification
            $user = Auth::user();
            if (method_exists($user, 'hasVerifiedEmail') && ! $user->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Please verify your email before logging in.']);
            }

            // Optionally check if account blocked/disabled
            // if ($user->is_blocked) { Auth::logout(); ... }

            // Redirect based on role hint or primary role
            if ($user->hasRole('admin')) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->hasRole('vendor')) {
                return redirect()->intended(route('vendor.dashboard'));
            } elseif ($user->hasRole('delivery')) {
                return redirect()->intended(route('delivery.index'));
            } elseif ($user->hasRole('finance')) {
                return redirect()->intended(route('finance.index'));
            } elseif ($user->hasRole('crm')) {
                return redirect()->intended(route('crm.tickets.index'));
            } else {
                return redirect()->intended(route('account.dashboard'));
            }
        }

        // Increment attempts on failure
        RateLimiter::hit($throttleKey, 60); // decay 60 seconds

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Helper for throttle key: tie attempts to email + IP for better defense.
     */
    protected function throttleKey(Request $request)
    {
        $email = (string) Str::lower($request->input('email'));
        return 'login|'. $email .'|'. $request->ip();
    }
}
