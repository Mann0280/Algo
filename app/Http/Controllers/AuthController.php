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

        // Save registration data in session instead of creating the user immediately
        session(['registration_data' => [
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => $request->referral_code,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]]);

        try {
            \Illuminate\Support\Facades\Mail::to($request->email)->send(new \App\Mail\OtpVerificationMail($request->username, $otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('OTP Email Sending Failed during registration: ' . $e->getMessage());
        }

        return redirect()->route('verification.notice');
    }

    /**
     * Show the email verification notice.
     */
    public function verificationNotice()
    {
        if (!session()->has('registration_data')) {
            return redirect()->route('register');
        }
        return view('auth.verify-otp');
    }

    /**
     * Handle the OTP verification request.
     */
    public function verifyOtp(Request $request)
    {
        if (!session()->has('registration_data')) {
            return redirect()->route('register');
        }

        $request->validate([
            'otp' => 'required|array|size:6',
        ]);
        
        $otpString = implode('', $request->otp);
        $data = session('registration_data');
        
        if ($data['otp'] !== $otpString || now()->greaterThan($data['expires_at'])) {
            return back()->withErrors(['otp' => 'Invalid or expired verification code.']);
        }
        
        // Finalize User Creation
        $referredBy = null;
        if (!empty($data['referral_code'])) {
            $referrer = User::where('referral_code', $data['referral_code'])->first();
            if ($referrer) {
                $referredBy = $referrer->id;
            }
        }

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'user',
            'referred_by' => $referredBy,
            'email_verified_at' => now(),
        ]);

        if ($referredBy) {
            \App\Models\Referral::create([
                'referrer_id' => $referredBy,
                'referred_user_id' => $user->id,
                'reward_amount' => 100.00,
                'status' => 'pending',
            ]);
        }

        session()->forget('registration_data');
        Auth::login($user);
        
        return redirect()->intended('/?verified=1')->with('success', 'Email verified and account created successfully.');
    }

    /**
     * Resend the email verification notification.
     */
    public function resendVerification(Request $request)
    {
        if (!session()->has('registration_data')) {
            return redirect()->route('register');
        }

        $data = session('registration_data');
        $otp = (string) random_int(100000, 999999);
        $data['otp'] = $otp;
        $data['expires_at'] = now()->addMinutes(5);
        
        session(['registration_data' => $data]);
        
        try {
            \Illuminate\Support\Facades\Mail::to($data['email'])->send(new \App\Mail\OtpVerificationMail($data['username'], $otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('OTP Email Resend Failed: ' . $e->getMessage());
            return back()->withErrors(['otp' => 'Failed to send email. Please check SMTP configuration.']);
        }
        
        return back()->with('status', 'New verification code has been sent to your email.');
    }

    /**
     * Cancel registration from OTP screen
     */
    public function cancelRegistration()
    {
        session()->forget('registration_data');
        return redirect()->route('register');
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
