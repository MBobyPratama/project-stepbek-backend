<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\OauthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

// OAuth routes
Route::prefix('oauth')->group(function () {
    Route::get('google', [OauthController::class, 'redirectToGoogle']);
    Route::get('google/callback', [OauthController::class, 'handleGoogleCallback']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

// User routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
});

// Event routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('events', [EventController::class, 'index']);
    Route::post('events', [EventController::class, 'store']);
    Route::get('events/{id}', [EventController::class, 'show']);
    Route::put('events/{id}', [EventController::class, 'update']);
    Route::delete('events/{id}', [EventController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/history', [HistoryController::class, 'index']);
    Route::post('/payment/initiate', [HistoryController::class, 'initiatePayment']);
    Route::get('/payment/status/{orderId}', [HistoryController::class, 'checkPaymentStatus']);
    Route::get('/tickets', [HistoryController::class, 'getTickets']);
    Route::get('/history/{history}', [HistoryController::class, 'show']);
    Route::get('/payment/{orderId}/force-check', [HistoryController::class, 'forceCheckPaymentStatus']);
});



// Public route for Midtrans notification
Route::post('/payment/notification', [HistoryController::class, 'handleNotification']);

Route::post('/get-snap-token', [PaymentController::class, 'getSnapToken']);
