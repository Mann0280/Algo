<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StockSignal;

class PredictionController extends Controller
{
    /**
     * Display a listing of past signals for management.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $today = now()->toDateString();
        
        // Retrieve and filter signals using the exact same logic as SignalController
        $query = StockSignal::query()
            ->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') < STR_TO_DATE(?, '%Y-%m-%d')", [$today]);

        if ($request->filled('start_date')) {
            $query->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') >= STR_TO_DATE(?, '%Y-%m-%d')", [$request->start_date]);
        }

        if ($request->filled('end_date')) {
            $query->whereRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') <= STR_TO_DATE(?, '%Y-%m-%d')", [$request->end_date]);
        }

        if ($request->filled('symbol')) {
            $query->where('stock_name', 'LIKE', '%' . strtoupper($request->symbol) . '%');
        }

        if ($request->filled('signal_type')) {
            $query->where('signal_type', strtoupper($request->signal_type));
        }

        if ($request->filled('result')) {
            $res = strtoupper($request->result);
            if ($res === 'WIN') {
                $query->where('pnl', '>', 0);
            } elseif ($res === 'LOSS') {
                $query->where('pnl', '<', 0);
            } else {
                $query->where('result', $res);
            }
        }

        $predictions = $query->orderByRaw("STR_TO_DATE(entry_date, '%Y-%m-%d') DESC")
            ->orderBy('entry_time', 'DESC')
            ->get();

        return view('admin.predictions.index', compact('predictions'));
    }

    /**
     * Remove the specified signal transmission.
     *
     * @param  StockSignal $prediction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(StockSignal $prediction)
    {
        $prediction->delete();
        return redirect()->back()->with('success', 'Historical signal transmission purged.');
    }
}
