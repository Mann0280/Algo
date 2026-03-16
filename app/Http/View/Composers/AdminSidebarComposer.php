<?php

namespace App\Http\View\Composers;

use App\Models\PaymentRequest;
use App\Models\WithdrawRequest;
use Illuminate\View\View;

class AdminSidebarComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $pendingPaymentsCount = PaymentRequest::where('status', 'pending')->count();
        $pendingWithdrawsCount = WithdrawRequest::where('status', 'pending')->count();

        $view->with('pendingPaymentsCount', $pendingPaymentsCount);
        $view->with('pendingWithdrawsCount', $pendingWithdrawsCount);
    }
}
