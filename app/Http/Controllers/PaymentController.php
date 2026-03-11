<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentRequest;
use App\Models\PremiumPackage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Show the dedicated payment page for a package.
     */
    public function show($package_id)
    {
        $package = PremiumPackage::findOrFail($package_id);
        
        $upiId = \App\Models\SiteSetting::getValue('wallet_upi_id', 'merchant@upi');
        $upiName = \App\Models\SiteSetting::getValue('wallet_upi_name', 'Merchant');
        
        return view('payment.index', compact('package', 'upiId', 'upiName'));
    }

    /**
     * Submit the payment request for verification.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:premium_packages,id',
            'utr' => 'required|string|unique:payment_requests,utr_number',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        $data = [
            'user_id' => $user->id,
            'package_id' => $request->package_id,
            'amount' => $request->amount ?? PremiumPackage::find($request->package_id)->price,
            'utr_number' => $request->utr,
            'status' => 'pending',
            'type' => 'upgrade',
        ];

        if ($request->hasFile('screenshot')) {
            $imageName = time() . '_' . $user->id . '.' . $request->screenshot->extension();
            $request->screenshot->move(public_path('uploads/payments'), $imageName);
            $data['payment_screenshot'] = 'uploads/payments/' . $imageName;
        }

        PaymentRequest::create($data);

        return redirect()->route('account.subscription-history')
            ->with('success', 'Payment submitted for verification. Our team will verify it shortly.');
    }

    /**
     * Admin: List all specific sub payment requests.
     */
    public function adminPaymentRequests()
    {
        $requests = PaymentRequest::with(['user', 'package'])->latest()->paginate(15);
        return view('admin.payment_requests.index', compact('requests'));
    }

    /**
     * Submit a payment request from the user.
     */
    public function submitPayment(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:premium_packages,id',
            'amount' => 'required|numeric|min:0',
            'transaction_id' => 'required|string|unique:payments,transaction_id',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        // Check for pending payment to prevent spam
        $pendingPayment = Payment::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($pendingPayment) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a pending payment request. Please wait for verification.'
            ], 422);
        }

        $data = $request->only(['package_id', 'amount', 'transaction_id']);
        $data['user_id'] = $user->id;
        $data['status'] = 'pending';

        if ($request->hasFile('screenshot')) {
            $imageName = time() . '.' . $request->screenshot->extension();
            $request->screenshot->move(public_path('uploads/payments'), $imageName);
            $data['screenshot'] = 'uploads/payments/' . $imageName;
        }

        Payment::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Payment request submitted successfully. Awaiting admin verification.'
        ]);
    }

    /**
     * Admin: List all payments and upgrade requests.
     */
    public function adminIndex()
    {
        // 1. Direct Payments (from legacy/direct flow)
        $payments = Payment::with(['user', 'package'])->latest()->get()->map(function($p) {
            $p->sync_type = 'payment';
            $p->display_amount = $p->amount;
            $p->display_reference = $p->transaction_id;
            $p->display_proof = $p->screenshot;
            $p->display_plan = $p->package->name ?? 'Direct Payment';
            return $p;
        });

        // 2. Payment Requests (New Purchase flow) - Only show those that are fully submitted (Step 4 completed)
        $requests = \App\Models\PaymentRequest::with(['user', 'package'])
            ->whereNotNull('utr_number')
            ->whereNotNull('payment_screenshot')
            ->latest()
            ->get()
            ->map(function($r) {
            $r->sync_type = 'request';
            $r->display_amount = $r->amount;
            $r->display_reference = $r->utr_number;
            $r->display_proof = $r->payment_screenshot;
            $r->display_plan = $r->package->name ?? $r->plan_name ?? 'Custom Sync';
            return $r;
        });

        // 3. Pending Wallet Transactions (Older logic remnants)
        $walletTx = \App\Models\WalletTransaction::with('user')
            ->where('type', 'credit')
            ->latest()->get()->map(function($t) {
                $t->sync_type = 'wallet';
                $t->display_amount = $t->amount;
                $t->display_reference = $t->payment_reference ?? 'N/A';
                $t->display_proof = $t->screenshot;
                $t->display_plan = 'Wallet Credit (' . $t->payment_method . ')';
                return $t;
            });

        // Merge and Paginate
        $merged = $payments->concat($requests)->concat($walletTx)->sortByDesc('created_at');
        
        // Manual pagination to keep view compatible
        $currentPage = \Illuminate\Support\Facades\Request::get('page', 1);
        $perPage = 15;
        $currentItems = $merged->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedItems = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $merged->count(), $perPage, $currentPage, [
            'path' => \Illuminate\Support\Facades\Request::url(),
            'query' => \Illuminate\Support\Facades\Request::query(),
        ]);

        return view('admin.payments.index', ['allRequests' => $paginatedItems]);
    }

    /**
     * Admin: Approve a payment.
     */
    public function approvePayment(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Payment is already processed.');
        }

        DB::beginTransaction();
        try {
            $payment->update([
                'status' => 'approved',
                'verified_at' => now(),
            ]);

            $user = $payment->user;
            $package = $payment->package;
            $expiry = $this->activatePackageForUser($user, $package, $payment->amount);

            DB::commit();
            return back()->with('success', "Payment approved. Premium activated for {$user->username} until " . $expiry->format('d M Y'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve payment: ' . $e->getMessage());
        }
    }

    /**
     * Admin: Reject a payment.
     */
    public function rejectPayment(Request $request, Payment $payment)
    {
        $request->validate([
            'rejection_note' => 'required|string|max:500',
        ]);

        if ($payment->status !== 'pending') {
            return back()->with('error', 'Payment is already processed.');
        }

        $payment->update([
            'status' => 'rejected',
            'rejection_note' => $request->rejection_note,
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Payment request rejected.');
    }

    /**
     * Admin: Approve P2P Upgrade Request.
     */
    public function approveUpgradeRequest(\App\Models\PaymentRequest $request)
    {
        if ($request->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }

        DB::beginTransaction();
        try {
            $user = $request->user;

            // 1. Approve Request
            $request->update([
                'status' => 'approved',
                'verified_at' => now()
            ]);

            if ($request->type === 'topup') {
                // Top-up Request
                $user->increment('wallet_balance', $request->amount);

                // Create Wallet Transaction (Credit)
                $user->walletTransactions()->create([
                    'type' => 'credit',
                    'amount' => $request->amount,
                    'description' => 'Wallet Top-Up (Admin Verified)',
                    'source' => 'topup',
                    'status' => 'success'
                ]);

                // Referral Reward Logic
                $referral = \App\Models\Referral::where('referred_user_id', $user->id)
                    ->where('status', 'pending')
                    ->first();

                if ($referral) {
                    $referrer = $referral->referrer;
                    if ($referrer) {
                        // Credit Referrer
                        $referrer->increment('wallet_balance', $referral->reward_amount);
                        
                        // Log Transaction for Referrer
                        $referrer->walletTransactions()->create([
                            'type' => 'credit',
                            'amount' => $referral->reward_amount,
                            'description' => "Referral Bonus: Invited {$user->username}",
                            'source' => 'referral_reward',
                            'status' => 'success'
                        ]);

                        // Mark Referral as Rewarded
                        $referral->update(['status' => 'rewarded']);
                    }
                }
            } else {
                // Plan Upgrade Request
                $package = $request->package;

                $expiry = $this->activatePackageForUser($user, $package, $request->amount);

                // Create Wallet Transaction (Manual Payment Debit Log)
                $user->walletTransactions()->create([
                    'type' => 'debit',
                    'amount' => $request->amount,
                    'description' => 'Premium Plan Upgrade (Manual P2P Verification)',
                    'status' => 'success'
                ]);
            }

            DB::commit();

            if ($request->type === 'topup') {
                return back()->with('success', "Top-up approved. ₹{$request->amount} credited to {$user->username}'s wallet.");
            } else {
                return back()->with('success', "Upgrade approved for {$user->username}. Premium protocol activated.");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Sync failed: ' . $e->getMessage());
        }
    }

    /**
     * Admin: Reject P2P Upgrade Request.
     */
    public function rejectUpgradeRequest(Request $httpRequest, \App\Models\PaymentRequest $paymentRequest)
    {
        $httpRequest->validate([
            'rejection_note' => 'required|string|max:500',
        ]);

        if ($paymentRequest->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }

        $paymentRequest->update([
            'status' => 'rejected',
            'rejection_note' => $httpRequest->rejection_note,
            'verified_at' => now()
        ]);

        return back()->with('success', 'Upgrade request rejected.');
    }

    /**
     * Activate a package for the given user and return the new expiry date.
     * Centralizes premium/elite upgrade logic across payment flows.
     */
    private function activatePackageForUser(User $user, ?PremiumPackage $package, float $amount): Carbon
    {
        $role = 'premium';
        if ($package && stripos($package->name, 'elite') !== false) {
            $role = 'elite';
        }

        $duration = $package ? $package->duration_days : 30; // fallback when package missing

        $startDate = ($user->premium_expiry instanceof Carbon && $user->premium_expiry->isFuture())
            ? $user->premium_expiry->copy()
            : now();

        $expiry = $startDate->addDays($duration);

        $user->role = $role;
        $user->premium_expiry = $expiry;
        $user->save();

        // Record subscription history to maintain audit trail
        \App\Models\SubscriptionHistory::create([
            'user_id'     => $user->id,
            'plan_name'   => $package->name ?? 'Manual Credit',
            'amount'      => $amount,
            'status'      => 'Completed',
            'purchased_at'=> now(),
            'expires_at'  => $expiry,
        ]);

        return $expiry;
    }
}
