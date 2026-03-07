<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PredictionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\PremiumPackageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
use App\Http\Controllers\AccountController;

use App\Http\Controllers\TerminalController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'storeContact']);
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::match(['get', 'post'], '/subscribe', [HomeController::class, 'handlePayment'])->middleware('auth')->name('subscribe');

Route::get('/signals', [\App\Http\Controllers\SignalsController::class, 'index'])->name('signals');
Route::get('/api/live-signals', [\App\Http\Controllers\Api\LiveTipsController::class, 'liveSignals'])->middleware('auth')->name('api.live-signals');
Route::get('/api/tutorial-videos', [\App\Http\Controllers\Api\LiveTipsController::class, 'tutorialVideos'])->middleware('auth')->name('api.tutorial-videos');

// Route::prefix('terminal')->name('terminal.')->middleware('auth')->group(function () {
//     Route::get('/', [TerminalController::class, 'index'])->name('index');
//     // Route::get('/free', [TerminalController::class, 'free'])->name('free');
//     // Route::get('/premium', [TerminalController::class, 'premiumTips'])->name('premium');
//     // Route::redirect('/premium-tips', '/terminal/premium');
//     // Route::redirect('/elite', '/terminal/premium');
//     Route::get('/charts', [TerminalController::class, 'charts'])->name('charts');
// });

Route::prefix('account')->name('account.')->middleware('auth')->group(function () {
    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::post('/profile', [AccountController::class, 'update'])->name('update');
    Route::post('/profile/password', [AccountController::class, 'updatePassword'])->name('update-password');
    Route::post('/profile/sessions/{id}/terminate', [AccountController::class, 'terminateSession'])->name('terminate-session');
    Route::get('/membership', [AccountController::class, 'membership'])->name('membership');
    Route::get('/history', [AccountController::class, 'subscriptionHistory'])->name('subscription-history');
    Route::get('/notifications', [AccountController::class, 'notifications'])->name('notifications');

    // Wallet Routes
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/add', [WalletController::class, 'addFunds'])->name('wallet.add');
    Route::post('/wallet/purchase-premium', [WalletController::class, 'purchasePremium'])->name('wallet.purchase-premium');
    Route::post('/upgrade-plan', [AccountController::class, 'upgradePlan'])->name('upgrade-plan');
    Route::post('/payment-request', [AccountController::class, 'submitPaymentRequest'])->name('payment-request');
});

Route::get('/api/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/api/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showAdminLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'adminLogin']);
    });

    Route::middleware(['auth:admin', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/broadcast-tip', [DashboardController::class, 'broadcastTip'])->name('broadcast-tip');
        Route::post('/broadcast-notification', [DashboardController::class, 'broadcastNotification'])->name('broadcast-notification');
        Route::resource('predictions', PredictionController::class);
        Route::resource('users', UserController::class);
        Route::resource('premium-packages', PremiumPackageController::class)->names([
            'index' => 'premium-packages.index',
            'create' => 'premium-packages.create',
            'store' => 'premium-packages.store',
            'edit' => 'premium-packages.edit',
            'update' => 'premium-packages.update',
            'destroy' => 'premium-packages.destroy',
        ]);
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

        // Payment Management
        Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'adminIndex'])->name('payments.index');
        Route::post('/payments/{payment}/approve', [\App\Http\Controllers\PaymentController::class, 'approvePayment'])->name('payments.approve');
        Route::post('/payments/{payment}/reject', [\App\Http\Controllers\PaymentController::class, 'rejectPayment'])->name('payments.reject');
        
        // Manual P2P Upgrade Request Routes
        Route::post('/payments/upgrade/{request}/approve', [\App\Http\Controllers\PaymentController::class, 'approveUpgradeRequest'])->name('payments.upgrade.approve');
        Route::post('/payments/upgrade/{paymentRequest}/reject', [\App\Http\Controllers\PaymentController::class, 'rejectUpgradeRequest'])->name('payments.upgrade.reject');
        
        // Educational Video Management
        Route::resource('tutorial-videos', \App\Http\Controllers\Admin\TutorialVideoController::class)->except(['show', 'create', 'edit'])->names([
            'index' => 'tutorial-videos.index',
            'store' => 'tutorial-videos.store',
            'update' => 'tutorial-videos.update',
            'destroy' => 'tutorial-videos.destroy',
        ]);

        // Wallet & Payment Settings
        Route::get('/settings/wallet', [\App\Http\Controllers\Admin\WalletSettingsController::class, 'index'])->name('settings.wallet');
        Route::post('/settings/wallet', [\App\Http\Controllers\Admin\WalletSettingsController::class, 'update'])->name('settings.wallet.update');

        // Wallet Verification
        Route::post('/wallet/approve/{transaction}', [WalletController::class, 'approveTopup'])->name('wallet.approve');
        Route::post('/wallet/reject/{transaction}', [WalletController::class, 'rejectTopup'])->name('wallet.reject');
    });
});

// Manual Payment System Submission
Route::middleware('auth')->group(function () {
    Route::post('/payment/submit', [\App\Http\Controllers\PaymentController::class, 'submitPayment'])->name('payment.submit');
});

// Past Signals Management
Route::get('/signals/past', [\App\Http\Controllers\SignalController::class, 'pastSignals'])->name('signals.past')->middleware('auth');
Route::get('/api/past-signals', [\App\Http\Controllers\Api\PastSignalsController::class, 'index'])->name('api.past-signals')->middleware(['auth', 'throttle:60,1']);
