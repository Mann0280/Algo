<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Helpers\JwtHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Show the admin login form.
     *
     * @return \Illuminate\View\View
     */
    public function showAdminLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            $token = JwtHelper::generate([
                'id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'exp' => time() + (60 * 60 * 24) // 24 hours
            ]);

            $response = (Auth::user()->role === 'admin') 
                ? redirect()->route('admin.dashboard')
                : redirect()->intended('/');

            return $response->withCookie(cookie('neural_token', $token, 1440, null, null, false, false));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials. Please verify your identity.',
        ])->onlyInput('email');
    }

    /**
     * Handle admin login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::guard('admin')->user();
            $token = JwtHelper::generate([
                'id' => $user->id,
                'email' => $user->email,
                'role' => 'admin',
                'exp' => time() + (60 * 60 * 24)
            ]);

            return redirect()->route('admin.dashboard')
                ->withCookie(cookie('neural_token', $token, 1440, null, null, false, false));
        }

        return back()->withErrors([
            'email' => 'Access Denied. Credentials not recognized by Admin Protocol.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'referral_code' => ['nullable', 'string', 'exists:users,referral_code'],
        ]);

        $referredBy = null;
        if ($request->referral_code) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
            if ($referrer) {
                $referredBy = $referrer->id;
            }
        }

        $otp = (string) random_int(100000, 999999);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'referred_by' => $referredBy,
            'email_verified' => false,
            'email_otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        if ($referredBy) {
            \App\Models\Referral::create([
                'referrer_id' => $referredBy,
                'referred_user_id' => $user->id,
                'reward_amount' => 100.00,
                'status' => 'pending',
            ]);
        }

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OtpVerificationMail($user->username, $otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('OTP Email Sending Failed during registration: ' . $e->getMessage());
        }

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    /**
     * Show the email verification notice.
     */
    public function verificationNotice()
    {
        return view('auth.verify-otp');
    }

    /**
     * Handle the OTP verification request.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|size:6',
        ]);
        
        $otpString = implode('', $request->otp);
        $user = Auth::user();
        
        if ($user->email_otp !== $otpString || now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Invalid or expired verification code.']);
        }
        
        $user->update([
            'email_verified' => true,
            'email_otp' => null,
            'otp_expires_at' => null,
        ]);
        
        return redirect()->intended('/?verified=1')->with('success', 'Email verified successfully.');
    }

    /**
     * Resend the email verification notification.
     */
    public function resendVerification(Request $request)
    {
        $user = Auth::user();
        
        $otp = (string) random_int(100000, 999999);
        $user->update([
            'email_otp' => $otp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);
        
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OtpVerificationMail($user->username, $otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('OTP Email Resend Failed: ' . $e->getMessage());
            return back()->withErrors(['otp' => 'Failed to send email. Please check SMTP configuration.']);
        }
        
        return back()->with('status', 'New verification code has been sent to your email.');
    }

    /**
     * Log the user out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
