<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawRequest;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawController extends Controller
{
    /**
     * Display a listing of withdrawal requests.
     */
    public function index()
    {
        $requests = WithdrawRequest::with('user')->latest()->paginate(15);
        return view('admin.withdraws.index', compact('requests'));
    }

    /**
     * Approve a withdrawal request.
     */
    public function approve(WithdrawRequest $withdrawRequest)
    {
        if ($withdrawRequest->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }

        $user = $withdrawRequest->user;
        if ($user->wallet_balance < $withdrawRequest->amount) {
            return back()->with('error', 'User has insufficient balance to complete this withdrawal.');
        }

        DB::beginTransaction();
        try {
            // 1. Mark as approved
            $withdrawRequest->update(['status' => 'approved']);

            // 2. Deduct wallet balance
            $user->decrement('wallet_balance', $withdrawRequest->amount);

            // 3. Update the pending wallet transaction record
            $transaction = $user->walletTransactions()
                ->where('type', 'withdraw')
                ->where('amount', $withdrawRequest->amount)
                ->where('status', 'pending')
                ->latest()
                ->first();

            if ($transaction) {
                $transaction->update([
                    'status' => 'success',
                    'description' => 'Withdrawal Request Approved & Disbursed'
                ]);
            } else {
                // Fallback: Create new record if pending one isn't found
                $user->walletTransactions()->create([
                    'type' => 'withdraw',
                    'amount' => $withdrawRequest->amount,
                    'description' => 'Withdrawal Request Approved',
                    'status' => 'success',
                    'source' => 'withdraw'
                ]);
            }

            DB::commit();
            return back()->with('success', 'Withdrawal approved and balance deducted.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Approval failed: ' . $e->getMessage());
        }
    }

    /**
     * Reject a withdrawal request.
     */
    public function reject(Request $request, WithdrawRequest $withdrawRequest)
    {
        if ($withdrawRequest->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }

        $withdrawRequest->update(['status' => 'rejected']);
        
        return back()->with('success', 'Withdrawal request rejected.');
    }
}
