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
use App\Http\Controllers\Admin\WithdrawController as AdminWithdrawController;
use App\Http\Controllers\Api\FcmTokenController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Email Verification Routes (Guest / Pre-Registration Completion)
Route::middleware('guest')->group(function () {
    Route::get('/email/verify', [AuthController::class, 'verificationNotice'])->name('verification.notice');
    Route::post('/email/verify', [AuthController::class, 'verifyOtp'])->middleware('throttle:6,1')->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])->middleware('throttle:6,1')->name('verification.send');
    Route::post('/register/cancel', [AuthController::class, 'cancelRegistration'])->name('register.cancel');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/test-email', function () {
    try {
        $testRecipient = config('mail.from.address', 'info@stockpredictor.in');
        \Illuminate\Support\Facades\Mail::raw('Test Email Working - Sent at ' . now(), function ($message) use ($testRecipient) {
            $message->to($testRecipient)
                    ->subject('Test Mail - ' . config('app.name'));
        });
        return "Mail Sent Successfully to {$testRecipient}. Check your inbox to confirm.";
    } catch (\Exception $e) {
        $smtpHost = config('mail.mailers.smtp.host');
        $smtpPort = config('mail.mailers.smtp.port');
        $smtpEncryption = config('mail.mailers.smtp.encryption');
        \Illuminate\Support\Facades\Log::error("Test Email Failed: {$e->getMessage()} | SMTP: {$smtpHost}:{$smtpPort} ({$smtpEncryption})");
        return "Mail Failed: " . $e->getMessage() . "<br><br>SMTP Config: {$smtpHost}:{$smtpPort} (encryption: {$smtpEncryption})";
    }
});

Route::get('/test-email-config', function () {
    $config = [
        'mailer'     => config('mail.default'),
        'host'       => config('mail.mailers.smtp.host'),
        'port'       => config('mail.mailers.smtp.port'),
        'encryption' => config('mail.mailers.smtp.encryption'),
        'username'   => config('mail.mailers.smtp.username'),
        'from_address' => config('mail.from.address'),
        'from_name'  => config('mail.from.name'),
    ];
    return response()->json(['smtp_config' => $config, 'status' => 'These are the active SMTP settings loaded from your .env']);
});



use App\Http\Controllers\AccountController;

use App\Http\Controllers\TerminalController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'storeContact']);
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::match(['get', 'post'], '/subscribe', [HomeController::class, 'handlePayment'])->middleware('auth')->name('subscribe');

Route::get('/signals', [\App\Http\Controllers\SignalsController::class, 'index'])->name('signals')->middleware(['auth', \App\Http\Middleware\EnsureOtpVerified::class]);
Route::get('/api/live-signals', [\App\Http\Controllers\Api\LiveTipsController::class, 'liveSignals'])->middleware(['auth', \App\Http\Middleware\EnsureOtpVerified::class])->name('api.live-signals');
Route::get('/api/tutorial-videos', [\App\Http\Controllers\Api\LiveTipsController::class, 'tutorialVideos'])->middleware(['auth', \App\Http\Middleware\EnsureOtpVerified::class])->name('api.tutorial-videos');

// Route::prefix('terminal')->name('terminal.')->middleware('auth')->group(function () {
//     Route::get('/', [TerminalController::class, 'index'])->name('index');
//     // Route::get('/free', [TerminalController::class, 'free'])->name('free');
//     // Route::get('/premium', [TerminalController::class, 'premiumTips'])->name('premium');
//     // Route::redirect('/premium-tips', '/terminal/premium');
//     // Route::redirect('/elite', '/terminal/premium');
//     Route::get('/charts', [TerminalController::class, 'charts'])->name('charts');
// });

Route::prefix('account')->name('account.')->middleware(['auth', \App\Http\Middleware\EnsureOtpVerified::class])->group(function () {
    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::post('/profile', [AccountController::class, 'update'])->name('update');
    Route::post('/profile/password', [AccountController::class, 'updatePassword'])->name('update-password');
    Route::post('/profile/sessions/{id}/terminate', [AccountController::class, 'terminateSession'])->name('terminate-session');
    Route::get('/membership', [AccountController::class, 'membership'])->name('membership');
    // Plan Purchase & Payments (Previously Wallet Topup)
    Route::post('/plan-purchase/init', [AccountController::class, 'initWalletTopup'])->name('plan-purchase.init');
    Route::post('/plan-purchase/verify', [AccountController::class, 'verifyTopupAmount'])->name('plan-purchase.verify');
    Route::post('/plan-purchase/submit', [AccountController::class, 'submitWalletTopup'])->name('plan-purchase.submit');
    Route::post('/payment-request', [AccountController::class, 'submitPaymentRequest'])->name('payment-request');
    Route::post('/upgrade-plan', [AccountController::class, 'upgradePlan'])->name('upgrade-plan');

    // Wallet, Referral & History
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::get('/referral', [WalletController::class, 'referral'])->name('referral');
    Route::get('/withdraw', [WalletController::class, 'withdraw'])->name('withdraw');
    Route::post('/withdraw', [WalletController::class, 'storeWithdraw'])->name('withdraw.store');
    Route::get('/history', [AccountController::class, 'subscriptionHistory'])->name('subscription-history');
    Route::get('/receipt/{id}', [AccountController::class, 'receiptPrint'])->name('receipt');
    Route::get('/notifications', [AccountController::class, 'notifications'])->name('notifications');
    Route::post('/fcm-token', [FcmTokenController::class, 'updateToken'])->name('fcm-token.update');
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
        Route::get('/analytics', [DashboardController::class, 'analytics'])->name('analytics');
        Route::post('/broadcast-tip', [DashboardController::class, 'broadcastTip'])->name('broadcast-tip');
        Route::get('/notifications/broadcast', [DashboardController::class, 'showBroadcastNotification'])->name('notifications.broadcast');
        Route::post('/notifications/broadcast', [DashboardController::class, 'broadcastNotification']);
        Route::post('/notifications/test-push', [DashboardController::class, 'testPush'])->name('notifications.test-push');
        Route::resource('predictions', PredictionController::class);
        Route::resource('users', UserController::class);
        Route::post('/users/{user}/update-plan', [UserController::class, 'updatePlan'])->name('users.update-plan');
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

        // Referral Management
        Route::get('/referrals', [\App\Http\Controllers\Admin\ReferralController::class, 'index'])->name('referrals.index');

        // Withdraw Management
        Route::get('/withdraw-requests', [AdminWithdrawController::class, 'index'])->name('withdraw-requests.index');
        Route::post('/withdraw-requests/{withdrawRequest}/approve', [AdminWithdrawController::class, 'approve'])->name('withdraw-requests.approve');
        Route::post('/withdraw-requests/{withdrawRequest}/reject', [AdminWithdrawController::class, 'reject'])->name('withdraw-requests.reject');

        // New Subscription Payment Requests
        Route::get('/payment-requests', [\App\Http\Controllers\PaymentController::class, 'adminPaymentRequests'])->name('payment-requests.index');

        // Contact Message Management
        Route::get('/contact-messages', [\App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::delete('/contact-messages/{contactMessage}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
    });
});

// Manual Payment System Flow
Route::middleware('auth')->group(function () {
    Route::get('/payment/{package}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/submit', [\App\Http\Controllers\PaymentController::class, 'submit'])->name('payment.submit');
});

// Past Signals Management
Route::get('/signals/past', [\App\Http\Controllers\SignalController::class, 'pastSignals'])->name('signals.past');
Route::get('/api/past-signals', [\App\Http\Controllers\Api\PastSignalsController::class, 'index'])->name('api.past-signals')->middleware('throttle:60,1');
