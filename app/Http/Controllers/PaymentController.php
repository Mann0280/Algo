<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PremiumPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
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
        $payments = Payment::with(['user', 'package'])->orderBy('created_at', 'desc')->paginate(10, ['*'], 'payments_page');
        $upgradeRequests = \App\Models\PaymentRequest::with(['user', 'package'])->orderBy('created_at', 'desc')->paginate(10, ['*'], 'upgrades_page');
        
        $walletTransactions = \App\Models\WalletTransaction::with('user')
            ->where('type', 'credit')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.payments.index', compact('payments', 'walletTransactions', 'upgradeRequests'));
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

            // Activate Premium Role
            $user->role = 'premium';
            
            // Set expiry date
            $expiry = now()->addDays($package->duration_days);
            $user->premium_expiry = $expiry;
            $user->save();

            // Record in subscription history
            \App\Models\SubscriptionHistory::create([
                'user_id' => $user->id,
                'plan_name' => $package->name,
                'amount' => $payment->amount,
                'status' => 'Completed',
                'purchased_at' => now(),
                'expires_at' => $expiry,
            ]);

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
            $package = $request->package;

            // 1. Approve Request
            $request->update([
                'status' => 'approved',
                'verified_at' => now()
            ]);

            // 2. Activate Premium
            $expiry = now()->addDays($package->duration_days);
            $user->update([
                'role' => 'premium',
                'premium_expiry' => $expiry
            ]);

            // 3. Create Wallet Transaction (Manual Payment Debit Log)
            $user->walletTransactions()->create([
                'type' => 'debit',
                'amount' => $request->amount,
                'description' => 'Premium Plan Upgrade (Manual P2P Verification)',
                'status' => 'success'
            ]);

            // 4. Record Subscription History
            \App\Models\SubscriptionHistory::create([
                'user_id' => $user->id,
                'plan_name' => $package->name,
                'amount' => $request->amount,
                'status' => 'Completed',
                'purchased_at' => now(),
                'expires_at' => $expiry
            ]);

            DB::commit();
            return back()->with('success', "Upgrade approved for {$user->username}. Premium protocol activated.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Upgrade sync failed: ' . $e->getMessage());
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
}
