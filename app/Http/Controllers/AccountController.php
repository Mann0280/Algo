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

    /**
     * Update the user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'risk_strategy' => 'sometimes|string|in:Aggressive,Balanced',
            'default_allocation' => 'sometimes|string',
            'sl_threshold' => 'sometimes|numeric|min:0|max:100',
            'signal_sensitivity' => 'sometimes|numeric|min:0|max:1',
            'neural_confidence' => 'sometimes|integer|min:0|max:100',
            'learning_rate' => 'sometimes|numeric|min:0|max:1',
            'pattern_depth' => 'sometimes|string',
            'profile_photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Neural protocols synchronized successfully',
            'user' => [
                'username' => $user->username,
                'email' => $user->email,
                'initial' => strtoupper(substr($user->username, 0, 1)),
                'profile_photo_url' => $user->profile_photo ? asset('storage/' . $user->profile_photo) : null
            ]
        ]);
    }
}
