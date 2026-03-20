<?php

namespace App\Observers;

use App\Models\Notification;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;

class NotificationObserver
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    /**
     * Handle the Notification "created" event.
     */
    public function created(Notification $notification): void
    {
        try {
            // Determine if we should send a push notification
            // We ignore admin-only notifications for now to avoid spamming admins
            if ($notification->targeted_role === 'admin') {
                return;
            }

            if ($notification->user_id) {
                // Targeted notification to a specific user
                $user = $notification->user;
                if ($user && $user->fcm_token) {
                    $this->firebase->sendPushNotification(
                        $notification->title,
                        $notification->message,
                        $user->fcm_token,
                        ['notification_id' => $notification->id]
                    );
                }
            } else {
                // Broadcast notification
                $this->firebase->broadcast(
                    $notification->title,
                    $notification->message,
                    $notification->targeted_role ?? 'all',
                    ['notification_id' => $notification->id]
                );
            }
        } catch (\Exception $e) {
            Log::error('FCM Observer Error: ' . $e->getMessage());
        }
    }
}
