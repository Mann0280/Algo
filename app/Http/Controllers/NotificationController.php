<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get notifications for the authenticated premium user.
     */
    public function index()
    {
        $user = auth()->user();
        if (!$user) return response()->json(['notifications' => [], 'unreadCount' => 0]);

        $isAdmin = $user->role === 'admin';
        $isPremium = $user->role === 'premium' || $isAdmin;

        if (!$isPremium) {
            return response()->json(['notifications' => [], 'unreadCount' => 0]);
        }

        $notifications = Notification::where(function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhere('targeted_role', 'premium')
                  ->orWhere(function($q) {
                      $q->whereNull('user_id')->whereNull('targeted_role');
                  })
                  ->orWhere('targeted_role', 'all');
        })
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();

        $unreadCount = $notifications->where('read_at', null)->count();

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        
        // For individual notifications, update read_at
        if ($notification->user_id == auth()->id()) {
            $notification->update(['read_at' => now()]);
        }
        
        return response()->json(['success' => true]);
    }
}
