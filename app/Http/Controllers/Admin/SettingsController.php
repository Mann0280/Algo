<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SettingsController extends Controller
{
    /**
     * Show the admin settings page.
     */
    public function index()
    {
        $settings = [
            'site_name'        => SiteSetting::getValue('site_name', 'AlgoTrade AI'),
            'site_tagline'     => SiteSetting::getValue('site_tagline', 'Neural-Powered Trading Intelligence'),
            'support_email'    => SiteSetting::getValue('support_email', 'support@algotrade.ai'),
            'telegram_link'    => SiteSetting::getValue('telegram_link', ''),
            'breakeven_point'  => SiteSetting::getValue('breakeven_point', '2500.00'),
            'ai_refresh_rate'  => SiteSetting::getValue('ai_refresh_rate', '5'),
            'max_free_signals' => SiteSetting::getValue('max_free_signals', '3'),
            'premium_price'    => SiteSetting::getValue('premium_price', '999'),
            'maintenance_mode' => SiteSetting::getValue('maintenance_mode', '0'),
            'registration_open' => SiteSetting::getValue('registration_open', '1'),
        ];

        return view('admin.settings', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $keys = [
            'site_name', 'site_tagline', 'support_email', 'telegram_link',
            'breakeven_point', 'ai_refresh_rate', 'max_free_signals',
            'premium_price', 'maintenance_mode', 'registration_open',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                SiteSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $request->input($key)]
                );
            }
        }

        // Handle checkbox toggles (unchecked = not sent)
        $toggles = ['maintenance_mode', 'registration_open'];
        foreach ($toggles as $toggle) {
            SiteSetting::updateOrCreate(
                ['key' => $toggle],
                ['value' => $request->has($toggle) ? '1' : '0']
            );
        }

        return redirect()->route('admin.settings')->with('success', 'System configuration synchronized successfully.');
    }
}
