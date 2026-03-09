<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    /**
     * Show the user profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        
        // Fetch active sessions from the database
        $sessions = \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(function($session) {
                $ua = $session->user_agent;
                $device = 'Unknown Device';
                if (str_contains($ua, 'Windows')) $device = 'Windows PC';
                elseif (str_contains($ua, 'iPhone')) $device = 'iPhone';
                elseif (str_contains($ua, 'Android')) $device = 'Android Device';
                elseif (str_contains($ua, 'Macintosh')) $device = 'MacBook/iMac';

                $browser = 'Unknown Browser';
                if (str_contains($ua, 'Chrome')) $browser = 'Chrome';
                elseif (str_contains($ua, 'Firefox')) $browser = 'Firefox';
                elseif (str_contains($ua, 'Safari')) $browser = 'Safari';
                elseif (str_contains($ua, 'Edge')) $browser = 'Edge';
                
                return (object) [
                    'id' => $session->id,
                    'ip_address' => $session->ip_address,
                    'is_current_device' => $session->id === request()->session()->getId(),
                    'last_active' => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                    'device' => $browser . ' / ' . $device,
                    'location' => 'Ahmedabad, India' // Mocked as requested for the experience
                ];
            });

        $latestPayment = \App\Models\Payment::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $walletTransactions = $user->walletTransactions()->orderBy('created_at', 'desc')->get();
        $paymentRequests = \App\Models\PaymentRequest::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        
        $currentSubscription = \App\Models\SubscriptionHistory::where('user_id', $user->id)
            ->where('status', 'Completed')
            ->orderBy('purchased_at', 'desc')
            ->first();

        $preciseExpiry = ($currentSubscription && $currentSubscription->expires_at) 
            ? $currentSubscription->expires_at->format('Y-m-d H:i:s')
            : ($user->premium_expiry ? $user->premium_expiry . ' 23:59:59' : null);
            
        return view('account.profile', compact('user', 'sessions', 'latestPayment', 'walletTransactions', 'currentSubscription', 'preciseExpiry', 'paymentRequests'));
    }

    /**
     * Upgrade plan using wallet balance.
     */
    public function upgradePlan(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:premium_packages,id',
        ]);

        $user = Auth::user();
        $package = \App\Models\PremiumPackage::findOrFail($request->package_id);
        $amount = $package->price;

        if ($user->wallet_balance < $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient wallet balance. Please submit a P2P payment request.'
            ], 422);
        }

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // Deduct from wallet
            $user->decrement('wallet_balance', $amount);

            // Create wallet transaction (Debit)
            $user->walletTransactions()->create([
                'type' => 'debit',
                'amount' => $amount,
                'description' => 'Premium Plan Upgrade',
                'status' => 'success',
            ]);

            // Activate premium
            $expiry = now()->addDays($package->duration_days);
            $user->update([
                'role' => 'premium',
                'premium_expiry' => $expiry,
            ]);

            // Record in subscription history
            \App\Models\SubscriptionHistory::create([
                'user_id' => $user->id,
                'plan_name' => $package->name,
                'amount' => $amount,
                'status' => 'Completed',
                'purchased_at' => now(),
                'expires_at' => $expiry,
            ]);

            \Illuminate\Support\Facades\DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Premium protocol activated via wallet debit.'
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Sync failure: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit a P2P payment request.
     */
    public function submitPaymentRequest(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:premium_packages,id',
            'amount' => 'required|numeric',
            'utr_number' => 'required|string|unique:payment_requests,utr_number',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        $package = \App\Models\PremiumPackage::findOrFail($request->package_id);
        $screenshotPath = null;

        if ($request->hasFile('screenshot')) {
            $imageName = 'p2p_' . time() . '.' . $request->screenshot->extension();
            $request->screenshot->move(public_path('uploads/p2p'), $imageName);
            $screenshotPath = 'uploads/p2p/' . $imageName;
        }

        \App\Models\PaymentRequest::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'plan_name' => $package->name,
            'amount' => $request->amount,
            'utr_number' => $request->utr_number,
            'payment_screenshot' => $screenshotPath,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'P2P protocol request submitted. Pending manual verification.'
        ]);
    }

    /**
     * Update the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password Updated Successfully'
        ]);
    }

    /**
     * Terminate a specific session.
     *
     * @param  string  $sessionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function terminateSession($sessionId)
    {
        $user = Auth::user();
        
        \Illuminate\Support\Facades\DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', $user->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Secure session terminated'
        ]);
    }

    /**
     * Initialize Wallet Top-Up (Creates Pending Request)
     */
    public function initWalletTopup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100|max:50000',
        ]);

        $user = Auth::user();

        // Create a pending topup request
        $paymentRequest = \App\Models\PaymentRequest::create([
            'user_id' => $user->id,
            'type' => 'topup',
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'payment_request_id' => $paymentRequest->id,
            'amount' => $request->amount,
        ]);
    }

    /**
     * Verify UTR Amount for Wallet Top-Up (Step 3)
     */
    public function verifyTopupAmount(Request $request)
    {
        $request->validate([
            'payment_request_id' => 'required|exists:payment_requests,id',
            'utr_number' => 'required|string|unique:payment_requests,utr_number',
        ]);

        $user = Auth::user();

        // Find existing request
        $paymentRequest = \App\Models\PaymentRequest::where('id', $request->payment_request_id)
                            ->where('user_id', $user->id)
                            ->where('type', 'topup')
                            ->first();

        if (!$paymentRequest) {
            return response()->json(['success' => false, 'message' => 'Invalid payment request.']);
        }

        // Mock Bank API Check
        // In a real scenario, this would call an external API with the UTR and get the paid amount
        $isVerified = $this->mockBankApiCheck($request->utr_number, $paymentRequest->amount);

        if (!$isVerified) {
            return response()->json([
                'success' => false,
                'message' => 'Payment amount validation failed. The UTR does not correspond to the requested amount.',
            ]);
        }

        // Verification successful, save UTR
        $paymentRequest->update([
            'utr_number' => $request->utr_number
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment amount verified successfully.',
        ]);
    }

    /**
     * Mock Bank API to verify the amount based on UTR.
     * For demonstration, we'll assume any UTR starting with 'ERROR' or length < 12 fails.
     */
    private function mockBankApiCheck($utr, $expectedAmount)
    {
        if (strlen($utr) < 12 || strtoupper(substr($utr, 0, 5)) === 'ERROR') {
            return false;
        }
        // Assume valid and amount matches
        return true;
    }

    /**
     * Submit Proof for Wallet Top-Up (Step 4)
     */
    public function submitWalletTopup(Request $request)
    {
        $request->validate([
            'payment_request_id' => 'required|exists:payment_requests,id',
            'payment_method' => 'required|string',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        
        // Find existing request
        $paymentRequest = \App\Models\PaymentRequest::where('id', $request->payment_request_id)
                            ->where('user_id', $user->id)
                            ->where('type', 'topup')
                            ->whereNotNull('utr_number')
                            ->firstOrFail();

        $screenshotPath = null;
        if ($request->hasFile('screenshot')) {
            $imageName = 'topup_' . time() . '.' . $request->screenshot->extension();
            $request->screenshot->move(public_path('uploads/topups'), $imageName);
            $screenshotPath = 'uploads/topups/' . $imageName;
        }

        $paymentRequest->update([
            'payment_method' => $request->payment_method,
            'payment_screenshot' => $screenshotPath,
        ]);

        return back()->with('success', 'Wallet top-up proof submitted! Awaiting admin verification.');
    }

    /**
     * Show the subscription history.
     *
     * @return \Illuminate\View\View
     */
    public function subscriptionHistory()
    {
        $user = Auth::user();
        $history = \App\Models\SubscriptionHistory::where('user_id', $user->id)
            ->orderBy('purchased_at', 'desc')
            ->get();
            
        return view('account.history', compact('user', 'history'));
    }

    /**
     * Show the membership status.
     *
     * @return \Illuminate\View\View
     */
    public function membership()
    {
        $user = Auth::user();
        return view('account.membership', compact('user'));
    }

    /**
     * Show notifications.
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        $user = Auth::user();
        $isAdmin = $user->role === 'admin';
        $isPremium = $user->role === 'premium' || $isAdmin;

        if (!$isPremium) {
            $notifications = collect();
        } else {
            $notifications = \App\Models\Notification::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('targeted_role', 'premium')
                      ->orWhere(function($q) {
                          $q->whereNull('user_id')->whereNull('targeted_role');
                      })
                      ->orWhere('targeted_role', 'all');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        }

        return view('account.notifications', compact('user', 'notifications', 'isPremium'));
    }

    /**
     * Show the portfolio page.
     *
     * @return \Illuminate\View\View
     */
    /*
    public function portfolio()
    {
        $user = Auth::user();
        $isPremium = $user->role === 'premium' || $user->role === 'admin';

        $holdings = [
            ['stock' => 'RELIANCE', 'qty' => 50, 'avg' => 2450.50, 'ltp' => 2845.50, 'pnl' => '+₹19,750', 'change' => '+16.1%', 'up' => true],
            ['stock' => 'INFY', 'qty' => 120, 'avg' => 1420.20, 'ltp' => 1520.20, 'pnl' => '+₹12,000', 'change' => '+7.0%', 'up' => true],
            ['stock' => 'TATASTEEL', 'qty' => 300, 'avg' => 142.50, 'ltp' => 135.20, 'pnl' => '-₹2,190', 'change' => '-5.1%', 'up' => false],
            ['stock' => 'HDFCBANK', 'qty' => 80, 'avg' => 1650.40, 'ltp' => 1710.40, 'pnl' => '+₹4,800', 'change' => '+3.6%', 'up' => true],
        ];

        return view('account.portfolio', compact('user', 'isPremium', 'holdings'));
    }
    */

    /**
     * Show the wallet page.
     *
     * @return \Illuminate\View\View
     */
    /*
    public function wallet()
    {
        $user = Auth::user();
        $isPremium = $user->role === 'premium' || $user->role === 'admin';

        $transactions = [
            ['desc' => 'Deposit via UPI', 'type' => 'Deposit', 'amount' => 50000, 'status' => 'Success', 'date' => 'Today, 10:45 AM', 'up' => true],
            ['desc' => 'Premium Subscription', 'type' => 'Subscription', 'amount' => 4999, 'status' => 'Success', 'date' => 'Yesterday, 02:20 PM', 'up' => false],
            ['desc' => 'Withdrawal to Bank', 'type' => 'Withdrawal', 'amount' => 12000, 'status' => 'Success', 'date' => '2 days ago', 'up' => false],
            ['desc' => 'Deposit via NetBanking', 'type' => 'Deposit', 'amount' => 25000, 'status' => 'Success', 'date' => '3 days ago', 'up' => true],
            ['desc' => 'Trade Profit Credit', 'type' => 'Credit', 'amount' => 3420, 'status' => 'Success', 'date' => '4 days ago', 'up' => true],
        ];

        return view('account.wallet', compact('user', 'isPremium', 'transactions'));
    }
    */

    /**
     * Update the user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'risk_strategy' => 'sometimes|string|in:Aggressive,Balanced',
            'default_allocation' => 'sometimes|string',
            'sl_threshold' => 'sometimes|numeric|min:0|max:100',
            'signal_sensitivity' => 'sometimes|numeric|min:0|max:1',
            'neural_confidence' => 'sometimes|integer|min:0|max:100',
            'learning_rate' => 'sometimes|numeric|min:0|max:1',
            'pattern_depth' => 'sometimes|string',
            'profile_photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Neural protocols synchronized successfully',
            'user' => [
                'username' => $user->username,
                'email' => $user->email,
                'initial' => strtoupper(substr($user->username, 0, 1)),
                'profile_photo_url' => $user->profile_photo ? asset('storage/' . $user->profile_photo) : null
            ]
        ]);
    }

    /**
     * Show the referral dashboard.
     */
    public function referral()
    {
        $user = Auth::user();
        
        // Safety: Generate code if missing for legacy users
        if (!$user->referral_code) {
            $user->referral_code = \App\Models\User::generateUniqueReferralCode();
            $user->save();
        }
        
        $totalReferrals = $user->referrals()->count();
        $totalEarnings = \App\Models\WalletTransaction::where('user_id', $user->id)
            ->where('source', 'referral_reward')
            ->where('status', 'success')
            ->sum('amount');

        $referralList = \App\Models\Referral::with('referredUser')
            ->where('referrer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('account.referral', compact('user', 'totalReferrals', 'totalEarnings', 'referralList'));
    }

    /**
     * Show the printable receipt for a transaction.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function receiptPrint($id)
    {
        $user = Auth::user();
        $record = \App\Models\SubscriptionHistory::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();
            
        return view('account.receipt-print', compact('user', 'record'));
    }
}
