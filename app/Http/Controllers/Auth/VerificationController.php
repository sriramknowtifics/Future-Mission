<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    public function __construct()
    {
        // routes that require auth
        $this->middleware('auth');
    }

    /**
     * Show notice to verify email.
     */
    public function notice()
    {
        if (auth()->user() && auth()->user()->hasVerifiedEmail()) {
            return redirect()->intended('/');
        }
        return view('auth.verify-email');
    }

    /**
     * Handle the email verification link click (signed route).
     */
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/')->with('info', 'Email already verified.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended('/')->with('success', 'Email verified successfully.');
    }

    /**
     * Resend verification email (throttled).
     */
    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // find user
        $user = \App\Models\User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'User not found.']);
        }
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Email is already verified.');
        }

        // throttle resend to once per minute using RateLimiter
        $key = 'verification-resend|'.$user->id;
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 1)) {
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($key);
            return back()->withErrors(['email' => "Please wait {$seconds} seconds before requesting again."]);
        }

        $user->sendEmailVerificationNotification();
        \Illuminate\Support\Facades\RateLimiter::hit($key, 60);

        return back()->with('success', 'Verification email resent.');
    }
}
