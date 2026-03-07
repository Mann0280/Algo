<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Signal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $total_users = User::count();
        $active_signals = Signal::count();
        
        $ai_accuracy = \App\Models\SiteSetting::getValue('ai_accuracy', '94.2');
        $net_revenue_val = \App\Models\SiteSetting::getValue('net_revenue', '154200.50');
        $net_revenue = "₹" . number_format((float)$net_revenue_val, 0);

        $admin_name = Auth::user() ? Auth::user()->username : 'Admin';

        return view('admin.dashboard', compact(
            'total_users',
            'active_signals',
            'ai_accuracy',
            'net_revenue',
            'admin_name'
        ));
    }

    public function broadcastTip(Request $request)
    {
        $request->validate([
            'stock_name' => 'required|string|max:255',
            'entry_price' => 'required|numeric',
            'target_1' => 'required|numeric',
            'stop_loss' => 'required|numeric',
            'confidence' => 'required|integer|min:0|max:100',
            'risk_level' => 'required|in:Low,Medium,High',
            'trade_type' => 'required|in:Intraday,Swing,Long Term',
        ]);

        $tip = \App\Models\PremiumTip::create([
            'stock_name' => strtoupper($request->stock_name),
            'entry_price' => $request->entry_price,
            'target_1' => $request->target_1,
            'target_2' => $request->target_2 ?? $request->target_1 * 1.05,
            'target_3' => $request->target_3 ?? $request->target_1 * 1.10,
            'stop_loss' => $request->stop_loss,
            'confidence_percentage' => $request->confidence,
            'risk_level' => $request->risk_level,
            'trade_type' => $request->trade_type,
            'status' => 'Active',
        ]);

        // Trigger Notification for Premium Users
        \App\Models\Notification::create([
            'title' => 'New Elite Signal: ' . $tip->stock_name,
            'message' => "Potential {$tip->trade_type} {$tip->stock_name} opportunity at {$tip->entry_price}.",
            'targeted_role' => 'premium',
            'icon' => 'zap',
            'type' => 'success'
        ]);

        return redirect()->back()->with('success', 'Neural signal broadcasted and notifications deployed.');
    }

    public function broadcastNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'target' => 'required|in:all,premium,admin',
            'type' => 'required|in:info,success,warning,danger',
        ]);

        \App\Models\Notification::create([
            'title' => $request->title,
            'message' => $request->message,
            'targeted_role' => $request->target,
            'type' => $request->type,
            'icon' => $request->type === 'danger' ? 'alert-triangle' : ($request->type === 'success' ? 'check-circle' : 'bell'),
        ]);

        return redirect()->back()->with('success', 'Global neural broadcast complete.');
    }
}
