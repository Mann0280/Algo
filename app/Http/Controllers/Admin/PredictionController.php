<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Signal;

class PredictionController extends Controller
{
    /**
     * Display a listing of predictions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $predictions = Signal::orderBy('created_at', 'desc')->get();
        return view('admin.predictions.index', compact('predictions'));
    }

    /**
     * Store a new prediction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'symbol' => 'required|string|max:255',
            'price' => 'required|numeric',
            'confidence' => 'required|numeric',
        ]);

        Signal::create([
            'stock_symbol' => strtoupper($request->symbol),
            'entry_price' => $request->price,
            'confidence_level' => $request->confidence,
            'risk_level' => 'Medium', // Default for now
            'stop_loss' => $request->price * 0.95, // Dummy
            'target_1' => $request->price * 1.05, // Dummy
            'target_2' => $request->price * 1.10, // Dummy
            'is_premium' => true,
        ]);

        return redirect()->back()->with('success', 'Neural signal broadcasted successfully.');
    }

    /**
     * Remove the specified prediction.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Signal $prediction)
    {
        $prediction->delete();
        return redirect()->back()->with('success', 'Signal terminated.');
    }
}
