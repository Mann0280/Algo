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
        // Preview signals for the landing page
        $signals = Signal::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('home', compact('signals'));
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
        return view('pages.pricing', compact('isPremium'));
    }

    public function handlePayment()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Mock payment success logic
        $user->update([
            'role' => 'premium',
            'premium_expiry' => now()->addDays(30),
        ]);

        return redirect()->route('account.membership')
            ->with('success', 'Neural upgrade sequence complete. Welcome to ALGO-TRA.');
    }
}
