<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FcmTokenController extends Controller
{
    /**
     * Update the FCM token for the authenticated user.
     */
    public function updateToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $user = Auth::user();
        if ($user) {
            $user->update(['fcm_token' => $request->token]);
            return response()->json(['message' => 'Token updated successfully']);
        }

        return response()->json(['message' => 'User not authenticated'], 401);
    }
}
