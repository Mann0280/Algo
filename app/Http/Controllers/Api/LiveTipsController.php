<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TradingTip;
use Illuminate\Http\Request;

class LiveTipsController extends Controller
{
    public function index()
    {
        $tips = TradingTip::orderBy('created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'count' => $tips->count(),
            'data' => $tips
        ]);
    }
}
