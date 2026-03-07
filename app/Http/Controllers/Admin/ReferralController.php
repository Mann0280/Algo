<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $referrals = Referral::with(['referrer', 'referredUser'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.referrals.index', compact('referrals'));
    }
}
