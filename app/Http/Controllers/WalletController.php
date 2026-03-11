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
    // User-facing index and addFunds removed as wallet system is decommissioned on user side.

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

    // purchasePremium removed as wallet-based purchasing is decommissioned.
}
