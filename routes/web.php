<?php

use App\Http\Controllers\OauthController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\handleExceptions;

Route::get('/', function () {
    return view('welcome');
});

Route::get('oauth/google', [OauthController::class, 'redirectToGoogle']);
Route::get('oauth/google/callback', [OauthController::class, 'handleGoogleCallback']);

Route::post('/get-snap-token', [PaymentController::class, 'getSnapToken']);
Route::get('/pay', function () {
    return view('payment');
});
