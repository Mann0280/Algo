<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    /**
     * Show the user profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    /**
     * Show the membership status.
     *
     * @return \Illuminate\View\View
     */
    public function membership()
    {
        $user = Auth::user();
        return view('account.membership', compact('user'));
    }

    /**
     * Show notifications.
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        return view('account.notifications');
    }
}
