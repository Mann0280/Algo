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
     * Admin: List all payments.
     */
    public function adminIndex()
    {
        $payments = Payment::with(['user', 'package'])->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.payments.index', compact('payments'));
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
}
