<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WalletTransaction;
use App\Models\Payment;
use App\Models\PremiumPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Display wallet summary and transaction history.
     */
    public function index()
    {
        $user = Auth::user();
        $transactions = $user->walletTransactions()->orderBy('created_at', 'desc')->get();
        
        $walletSettings = [
            'upi_id' => \App\Models\SiteSetting::getValue('wallet_upi_id'),
            'upi_name' => \App\Models\SiteSetting::getValue('wallet_upi_name'),
            'qr_code' => \App\Models\SiteSetting::getValue('wallet_qr_code'),
        ];
        
        return view('account.wallet', compact('user', 'transactions', 'walletSettings'));
    }

    /**
     * Add funds to the user's wallet.
     */
    public function addFunds(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'payment_reference' => 'required|string|unique:wallet_transactions,payment_reference',
            'screenshot' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        $screenshotPath = null;

        if ($request->hasFile('screenshot')) {
            $imageName = 'wallet_' . time() . '.' . $request->screenshot->extension();
            $request->screenshot->move(public_path('uploads/wallet'), $imageName);
            $screenshotPath = 'uploads/wallet/' . $imageName;
        }

        try {
            // Create pending transaction record
            $user->walletTransactions()->create([
                'type' => 'credit',
                'amount' => $request->amount,
                'description' => 'Wallet Top-up Request',
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_reference' => $request->payment_reference,
                'screenshot' => $screenshotPath,
            ]);

            return back()->with('success', 'Neural synchronization request submitted. Active verification in progress.');
        } catch (\Exception $e) {
            return back()->with('error', 'Sync failure: ' . $e->getMessage());
        }
    }

    /**
     * Admin: Approve top-up request.
     */
    public function approveTopup(WalletTransaction $transaction)
    {
        if ($transaction->status !== 'pending' || $transaction->type !== 'credit') {
            return back()->with('error', 'Transaction cannot be approved.');
        }

        DB::beginTransaction();
        try {
            $transaction->update(['status' => 'approved']);
            $transaction->user->increment('wallet_balance', $transaction->amount);

            DB::commit();
            return back()->with('success', 'Neural credits authorized. Wallet updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Logic failure: ' . $e->getMessage());
        }
    }

    /**
     * Admin: Reject top-up request.
     */
    public function rejectTopup(WalletTransaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaction already finalized.');
        }

        $transaction->update(['status' => 'rejected']);
        return back()->with('success', 'Neural credit request rejected.');
    }

    /**
     * Purchase a premium package using wallet balance.
     */
    public function purchasePremium(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:premium_packages,id',
        ]);

        $user = Auth::user();
        $package = PremiumPackage::findOrFail($request->package_id);
        $amount = $package->price;

        // 1. Check if balance is sufficient
        if ($user->wallet_balance < $amount) {
            return back()->with('error', 'Insufficient wallet balance. Please add funds.');
        }

        DB::beginTransaction();
        try {
            // 2. Deduct amount from wallet
            $user->decrement('wallet_balance', $amount);

            // 3. Create wallet transaction record (Debit)
            $user->walletTransactions()->create([
                'type' => 'debit',
                'amount' => $amount,
                'description' => 'Premium Subscription: ' . $package->name,
                'status' => 'success',
            ]);

            // 4. Create record in payments table for admin visibility
            Payment::create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'amount' => $amount,
                'transaction_id' => 'WALLET-' . strtoupper(uniqid()),
                'status' => 'approved', // Auto-approved since using wallet
                'screenshot' => 'wallet_payment.png', // Placeholder
            ]);

            // 5. Activate premium membership
            $expiry = now()->addDays($package->duration_days);

            // 6. Record in subscription history
            \App\Models\SubscriptionHistory::create([
                'user_id' => $user->id,
                'plan_name' => $package->name,
                'amount' => $amount,
                'status' => 'Completed',
                'purchased_at' => now(),
                'expires_at' => $expiry,
            ]);

            $user->update([
                'role' => 'premium',
                'premium_expiry' => $expiry,
            ]);

            DB::commit();
            return redirect()->route('profile')->with('success', 'Premium subscription activated successfully using your wallet!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Internal error occurred: ' . $e->getMessage());
        }
    }
}
