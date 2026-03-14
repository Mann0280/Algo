<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'email_verified_at',
        'role',
        'risk_strategy',
        'default_allocation',
        'sl_threshold',
        'signal_sensitivity',
        'neural_confidence',
        'learning_rate',
        'pattern_depth',
        'profile_photo',
        'premium_expiry',
        'wallet_balance',
        'referral_code',
        'referred_by',
        'premium_plan',
        'premium_source',
        'is_blocked',
        'otp',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'premium_expiry' => 'datetime',
            'wallet_balance' => 'decimal:2',
            'otp_expires_at' => 'datetime',
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (!$user->referral_code) {
                $user->referral_code = static::generateUniqueReferralCode();
            }
        });
    }

    /**
     * Generate a unique referral code.
     */
    public static function generateUniqueReferralCode()
    {
        do {
            $code = 'EMP' . strtoupper(Str::random(5));
        } while (static::where('referral_code', $code)->exists());

        return $code;
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function referralRewards()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function watchlist()
    {
        return $this->hasMany(Watchlist::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function withdrawRequests()
    {
        return $this->hasMany(WithdrawRequest::class);
    }

    public function premiumSubscriptions()
    {
        return $this->hasMany(PremiumSubscription::class);
    }
}
