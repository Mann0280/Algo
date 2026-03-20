<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $credentials;
    protected $projectId;

    public function __construct()
    {
        $path = storage_path('app/firebase-service-account.json');
        if (!file_exists($path)) {
            Log::error('Firebase Service Account file not found at: ' . $path);
            return;
        }

        try {
            $this->credentials = new ServiceAccountCredentials(
                'https://www.googleapis.com/auth/cloud-platform',
                $path
            );
            
            $json = json_decode(file_get_contents($path), true);
            $this->projectId = $json['project_id'] ?? config('services.firebase.project_id');
        } catch (\Exception $e) {
            Log::error('Firebase Service Initialization Error: ' . $e->getMessage());
        }
    }

    /**
     * Get OAuth2 Access Token for FCM v1
     */
    public function getAccessToken()
    {
        if (!$this->credentials) return null;
        try {
            $token = $this->credentials->fetchAuthToken();
            return $token['access_token'];
        } catch (\Exception $e) {
            Log::error('Failed to fetch Firebase Access Token: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Send Push Notification via FCM v1
     */
    public function sendPushNotification($title, $body, $token, $data = [], $image = null, $link = null)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken || !$this->projectId) {
            Log::error('FCM Error: Missing Access Token or Project ID');
            return false;
        }

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        $notificationPayload = [
            'title' => $title,
            'body' => $body,
        ];

        if ($image) {
            $notificationPayload['image'] = $image;
        }

        $payload = [
            'message' => [
                'token' => $token,
                'notification' => $notificationPayload,
                'data' => array_map('strval', array_merge($data, [
                    'click_action' => 'OPEN_SIGNALS',
                ])),
                'webpush' => [
                    'fcm_options' => [
                        'link' => $link ?? url('/signals')
                    ],
                    'notification' => [
                        'image' => $image
                    ]
                ]
            ],
        ];

        $response = Http::withToken($accessToken)
            ->post($url, $payload);

        if ($response->successful()) {
            return true;
        }

        Log::error('FCM Direct Send Error: ' . $response->body());
        return false;
    }

    /**
     * Send Broadcast to all users with tokens
     */
    public function broadcast($title, $body, $role = 'all', $data = [], $image = null, $link = null)
    {
        $query = \App\Models\User::whereNotNull('fcm_token');
        
        if ($role !== 'all') {
            $query->where('role', $role);
        }

        $tokens = $query->pluck('fcm_token')->toArray();
        $successCount = 0;

        foreach ($tokens as $token) {
            if ($this->sendPushNotification($title, $body, $token, $data, $image, $link)) {
                $successCount++;
            }
        }

        return $successCount;
    }
}
