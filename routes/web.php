<?php

use App\Http\Controllers\OauthController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\handleExceptions;

Route::get('/', function () {
    return view('welcome');
});

Route::get('oauth/google/callback', [OauthController::class, 'handleProviderCallback'])
    ->middleware(['web'])
    ->name('oauth.google.callback');
