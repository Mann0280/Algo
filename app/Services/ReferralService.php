<?php

namespace App\Services;

use App\Models\User;
use App\Models\Referral;

class ReferralService
{
    /**
     * Process referral reward for a successful plan purchase.
     *
     * @param User $user The purchaser
     * @param mixed $package PremiumPackage object or plan name string
     * @param float $amount The amount paid
     * @return void
     */
    public static function processReward(User $user, $package, float $amount)
    {
        // 1. Check if user was referred
        $referral = Referral::where('referred_user_id', $user->id)
            ->whereIn('status', ['pending', 'rewarded'])
            ->first();

        if (!$referral) {
            return;
        }

        $referrer = $referral->referrer;
        if (!$referrer || $referrer->id === $user->id) {
            return;
        }

        // 2. Determine reward amount based on plan price tiers
        $rewardAmount = 0;
        if ($amount >= 30000) $rewardAmount = 5000;
        elseif ($amount >= 3000) $rewardAmount = 500;
        elseif ($amount >= 1500) $rewardAmount = 250;
        elseif ($amount >= 200) $rewardAmount = 50;

        if ($rewardAmount <= 0) {
            return;
        }

        // 3. Credit Referrer and Log Transaction
        $referrer->increment('wallet_balance', $rewardAmount);

        $referrer->walletTransactions()->create([
            'user_id' => $referrer->id,
            'type' => 'credit',
            'amount' => $rewardAmount,
            'description' => "Referral reward from {$user->username} purchase",
            'source' => 'referral_reward',
            'status' => 'success'
        ]);

        // 4. Update Referral record
        $planName = is_string($package) ? $package : ($package->name ?? 'Custom Plan');

        $referral->update([
            'plan_name' => $planName,
            'plan_amount' => $amount,
            'reward_amount' => $referral->reward_amount + $rewardAmount,
            'status' => 'rewarded'
        ]);
    }
}
