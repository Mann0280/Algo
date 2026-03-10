<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Signal;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $isPremium = $user ? ($user->role === 'premium' || $user->role === 'admin') : false;

        // Preview signals for the landing page
        $signals = Signal::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get up to 3 packages for homepage
        $packages = \App\Models\PremiumPackage::where('is_active', true)->orderBy('price', 'asc')->limit(3)->get();

        return view('home', compact('signals', 'isPremium', 'packages'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        ContactMessage::create($request->all());

        return back()->with('success', 'Transmission successful. Our analysts will synchronize with you within 24 hours.');
    }

    public function pricing()
    {
        $user = Auth::user();
        $isPremium = $user ? ($user->role === 'premium' || $user->role === 'admin') : false;
        $walletBalance = $user ? $user->wallet_balance : 0;
        $packages = \App\Models\PremiumPackage::where('is_active', true)->orderBy('price', 'asc')->get();
        return view('pages.pricing', compact('isPremium', 'packages', 'walletBalance'));
    }

    public function handlePayment(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $package = \App\Models\PremiumPackage::findOrFail($request->package_id);

        // Mock payment success logic
        $user->update([
            'role' => 'premium',
            'premium_expiry' => now()->addDays($package->duration_days),
        ]);

        // Record in history
        \App\Models\SubscriptionHistory::create([
            'user_id' => $user->id,
            'plan_name' => $package->name,
            'amount' => $package->price,
            'status' => 'Completed',
            'purchased_at' => now(),
            'expires_at' => now()->addDays($package->duration_days),
        ]);

        return redirect()->route('account.subscription-history')
            ->with('success', 'Neural upgrade sequence complete. Welcome to ALGO-TRADE Elite.');
    }
}
