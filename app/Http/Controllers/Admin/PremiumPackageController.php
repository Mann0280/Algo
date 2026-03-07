<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PremiumPackage;
use Illuminate\Http\Request;

class PremiumPackageController extends Controller
{
    /**
     * Display a listing of the premium packages.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $packages = PremiumPackage::orderBy('price', 'asc')->get();
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new premium package.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created premium package in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tag' => 'nullable|string|max:50',
            'tag_names' => 'nullable|array',
            'tag_colors' => 'nullable|array',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'upi_id' => 'nullable|string|max:255',
            'upi_name' => 'nullable|string|max:255',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'payment_info' => 'nullable|string',
            'button_color' => 'nullable|string|max:20',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
        ]);

        $data = $request->except('qr_code');
        $data['features'] = array_filter($request->features ?? []);
        
        // Process QR code upload
        if ($request->hasFile('qr_code')) {
            $imageName = time() . '.' . $request->qr_code->extension();
            $request->qr_code->move(public_path('uploads/qr_codes'), $imageName);
            $data['qr_code'] = 'uploads/qr_codes/' . $imageName;
        }

        // Process tags_json
        $tags = [];
        if ($request->has('tag_names')) {
            foreach ($request->tag_names as $index => $name) {
                if (!empty($name)) {
                    $tags[] = [
                        'name' => $name,
                        'color' => $request->tag_colors[$index] ?? '#8B5CF6'
                    ];
                }
            }
        }
        $data['tags_json'] = $tags;

        PremiumPackage::create($data);

        return redirect()->route('admin.premium-packages.index')
            ->with('success', 'Neural package protocol initialized.');
    }

    /**
     * Show the form for editing the specified premium package.
     *
     * @param  \App\Models\PremiumPackage  $premiumPackage
     * @return \Illuminate\View\View
     */
    public function edit(PremiumPackage $premiumPackage)
    {
        return view('admin.packages.edit', compact('premiumPackage'));
    }

    /**
     * Update the specified premium package in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PremiumPackage  $premiumPackage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PremiumPackage $premiumPackage)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tag' => 'nullable|string|max:50',
            'tag_names' => 'nullable|array',
            'tag_colors' => 'nullable|array',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'upi_id' => 'nullable|string|max:255',
            'upi_name' => 'nullable|string|max:255',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'payment_info' => 'nullable|string',
            'button_color' => 'nullable|string|max:20',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
        ]);

        $data = $request->except('qr_code');
        $data['features'] = array_filter($request->features ?? []);
        $data['is_active'] = $request->has('is_active');

        // Process QR code upload
        if ($request->hasFile('qr_code')) {
            // Delete old QR code if exists
            if ($premiumPackage->qr_code && file_exists(public_path($premiumPackage->qr_code))) {
                @unlink(public_path($premiumPackage->qr_code));
            }

            $imageName = time() . '.' . $request->qr_code->extension();
            $request->qr_code->move(public_path('uploads/qr_codes'), $imageName);
            $data['qr_code'] = 'uploads/qr_codes/' . $imageName;
        }
        
        // Process tags_json
        $tags = [];
        if ($request->has('tag_names')) {
            foreach ($request->tag_names as $index => $name) {
                if (!empty($name)) {
                    $tags[] = [
                        'name' => $name,
                        'color' => $request->tag_colors[$index] ?? '#8B5CF6'
                    ];
                }
            }
        }
        $data['tags_json'] = $tags;

        $premiumPackage->update($data);

        return redirect()->route('admin.premium-packages.index')
            ->with('success', 'Neural package protocol updated.');
    }

    /**
     * Remove the specified premium package from storage.
     *
     * @param  \App\Models\PremiumPackage  $premiumPackage
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PremiumPackage $premiumPackage)
    {
        $premiumPackage->delete();

        return redirect()->route('admin.premium-packages.index')
            ->with('success', 'Neural package protocol deconstructed.');
    }
}
