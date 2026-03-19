<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WalletSettingsController extends Controller
{
    /**
     * Display the wallet settings page.
     */
    public function index()
    {
        $settings = [
            'upi_id' => SiteSetting::getValue('wallet_upi_id', ''),
            'upi_name' => SiteSetting::getValue('wallet_upi_name', ''),
            'qr_code' => SiteSetting::getValue('wallet_qr_code', ''),
            'min_withdrawal' => SiteSetting::getValue('min_withdrawal_amount', '1'),
        ];

        return view('admin.settings.wallet', compact('settings'));
    }

    /**
     * Update wallet settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'wallet_upi_id' => 'required|string|max:255',
            'wallet_upi_name' => 'required|string|max:255',
            'wallet_qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'min_withdrawal_amount' => 'required|numeric|min:1',
        ]);

        // Save Text Settings
        SiteSetting::updateOrCreate(['key' => 'wallet_upi_id'], ['value' => $request->wallet_upi_id]);
        SiteSetting::updateOrCreate(['key' => 'wallet_upi_name'], ['value' => $request->wallet_upi_name]);
        SiteSetting::updateOrCreate(['key' => 'min_withdrawal_amount'], ['value' => $request->min_withdrawal_amount]);

        // Handle QR Code Upload
        if ($request->hasFile('wallet_qr_code')) {
            // Delete old QR if exists
            $oldQr = SiteSetting::getValue('wallet_qr_code');
            if ($oldQr && Storage::disk('public')->exists($oldQr)) {
                Storage::disk('public')->delete($oldQr);
            }

            $path = $request->file('wallet_qr_code')->store('settings', 'public');
            SiteSetting::updateOrCreate(['key' => 'wallet_qr_code'], ['value' => $path]);
        }

        return back()->with('success', 'Algo wallet protocols updated successfully.');
    }
}
