<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PredictionController;
use App\Http\Controllers\AuthController;

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

Route::get('/signals', [TerminalController::class, 'liveTips'])->name('live-tips')->middleware('auth');

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
    Route::get('/membership', [AccountController::class, 'membership'])->name('membership');
    Route::get('/notifications', [AccountController::class, 'notifications'])->name('notifications');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/broadcast-tip', [DashboardController::class, 'broadcastTip'])->name('broadcast-tip');
    Route::resource('predictions', PredictionController::class);
});
