<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LiveTipsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/live-tips', [LiveTipsController::class, 'index']);
