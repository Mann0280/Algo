<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::latest()->get();

        $usersJson = $users->map(function ($u) {
            return [
                'id' => $u->id,
                'username' => $u->username,
                'email' => $u->email,
                'role' => $u->role,
                'profile_photo' => $u->profile_photo ? asset('storage/' . $u->profile_photo) : null,
                'initial' => strtoupper(substr($u->username, 0, 1)),
                'created_at' => $u->created_at ? $u->created_at->format('d M Y') : 'N/A',
                'premium_expiry' => $u->premium_expiry ? $u->premium_expiry->format('d M Y') : null,
                'is_premium' => $u->premium_expiry && $u->premium_expiry->isFuture(),
                'edit_url' => route('admin.users.edit', $u->id),
                'delete_url' => route('admin.users.destroy', $u->id),
            ];
        });

        return view('admin.users.index', compact('users', 'usersJson'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:user,premium,admin',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:user,premium,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot self-destruct admin accounts.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Update the user's premium plan.
     */
    public function updatePlan(Request $request, User $user)
    {
        $durations = [
            'day' => 1,
            'week' => 7,
            'month' => 30,
            'year' => 365,
        ];

        $plan = $request->plan;

        if (!isset($durations[$plan])) {
            return back()->with('error', 'Invalid protocol duration selected.');
        }

        $days = $durations[$plan];

        // Determine start date for extension
        if ($user->premium_expiry && $user->premium_expiry->isFuture()) {
            $startDate = $user->premium_expiry;
        } else {
            $startDate = now();
        }

        // Calculate precise expiry
        $expiryDate = \Carbon\Carbon::parse($startDate)->addDays($days);

        // Update user state for high-performance scanning
        $user->premium_expiry = $expiryDate;
        $user->premium_plan = $plan;
        $user->premium_source = 'admin';
        $user->role = 'premium';
        $user->save();

        // Historical Audit Log
        \App\Models\PremiumSubscription::create([
            'user_id' => $user->id,
            'plan' => $plan,
            'price' => 0, // Admin override
            'start_date' => now(), // Time of administrative action
            'expiry_date' => $expiryDate,
            'source' => 'admin',
            'status' => 'active',
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', "Premium plan updated successfully. Node {$user->username} now active until " . $expiryDate->format('d M Y') . ".");
    }
}
