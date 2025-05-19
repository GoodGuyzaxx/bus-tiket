<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BusController;
use App\Http\Controllers\API\RouteController;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\PassengerController;
use App\Http\Controllers\API\PaymentController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/admin/register', [AuthController::class, 'register']);
Route::post('/admin/login', [AuthController::class, 'login']);

Route::post('/passenger/register', [PassengerController::class, 'register']);
Route::post('/passenger/login', [PassengerController::class, 'login']);

// Protected admin routes
Route::middleware('auth:api')->prefix('admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Bus routes
    Route::apiResource('buses', BusController::class);

    // Route routes
    Route::apiResource('routes', RouteController::class);

    // Ticket routes
    Route::apiResource('tickets', TicketController::class);
});

// Protected passenger routes
Route::middleware('auth:passenger')->prefix('passenger')->group(function () {
    Route::post('/logout', [PassengerController::class, 'logout']);
    Route::get('/profile', [PassengerController::class, 'profile']);
    Route::put('/profile', [PassengerController::class, 'updateProfile']);

    // Ticket routes
    Route::get('/tickets', [TicketController::class, 'userTickets']);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{ticket}', [TicketController::class, 'show']);

    // Payment routes
    Route::post('/payments', [PaymentController::class, 'createPayment']);
    Route::get('/payments/{orderId}', [PaymentController::class, 'getPaymentStatus']);
});

// Midtrans callback route (no auth required)
Route::post('/payments/callback', [PaymentController::class, 'handleCallback']);
