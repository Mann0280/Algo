<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WalletTransaction;
use App\Models\Referral;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Display the wallet dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'total_earnings' => Referral::where('referrer_id', $user->id)->where('status', 'rewarded')->sum('reward_amount'),
            'total_withdrawn' => WithdrawRequest::where('user_id', $user->id)->where('status', 'approved')->sum('amount'),
            'pending_withdraw' => WithdrawRequest::where('user_id', $user->id)->where('status', 'pending')->sum('amount'),
            'available_balance' => $user->wallet_balance - WithdrawRequest::where('user_id', $user->id)->where('status', 'pending')->sum('amount'),
        ];

        $transactions = WalletTransaction::where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('account.wallet', compact('user', 'stats', 'transactions'));
    }

    /**
     * Display the referral page.
     */
    public function referral()
    {
        $user = Auth::user();
        
        $referralLink = route('register', ['ref' => $user->referral_code]);
        
        $stats = [
            'total_referrals' => Referral::where('referrer_id', $user->id)->count(),
            'total_earnings' => Referral::where('referrer_id', $user->id)->where('status', 'rewarded')->sum('reward_amount'),
            'successful_purchases' => Referral::where('referrer_id', $user->id)->where('status', 'rewarded')->count(),
        ];

        $referrals = Referral::where('referrer_id', $user->id)
            ->with('referredUser')
            ->latest()
            ->paginate(15);

        return view('account.referral', compact('user', 'referralLink', 'stats', 'referrals'));
    }

    /**
     * Show the withdraw request form.
     */
    public function withdraw()
    {
        $user = Auth::user();
        $pendingWithdraw = WithdrawRequest::where('user_id', $user->id)->where('status', 'pending')->sum('amount');
        $availableBalance = $user->wallet_balance - $pendingWithdraw;

        return view('account.withdraw', compact('user', 'availableBalance'));
    }

    /**
     * Store a new withdraw request.
     */
    public function storeWithdraw(Request $request)
    {
        $user = Auth::user();
        
        $pendingWithdraw = WithdrawRequest::where('user_id', $user->id)->where('status', 'pending')->sum('amount');
        $availableBalance = $user->wallet_balance - $pendingWithdraw;

        $request->validate([
            'amount' => 'required|numeric|min:500|max:' . $availableBalance,
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:20',
            'upi_id' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            WithdrawRequest::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'ifsc_code' => $request->ifsc_code,
                'upi_id' => $request->upi_id,
                'status' => 'pending',
            ]);

            // Create a pending wallet transaction log
            $user->walletTransactions()->create([
                'type' => 'withdraw',
                'amount' => $request->amount,
                'description' => 'Withdrawal Request (Pending)',
                'status' => 'pending',
                'source' => 'withdraw'
            ]);

            DB::commit();
            return redirect()->route('account.wallet')->with('success', 'Withdrawal request submitted for approval.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to submit withdrawal request: ' . $e->getMessage());
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
}
