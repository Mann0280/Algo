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
            'button_color' => 'nullable|string|max:20',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['features'] = array_filter($request->features ?? []);
        
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
            'button_color' => 'nullable|string|max:20',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['features'] = array_filter($request->features ?? []);
        $data['is_active'] = $request->has('is_active');
        
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
