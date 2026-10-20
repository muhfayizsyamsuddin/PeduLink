<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\DonorController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\XenditWebhookController;

// Authentication
Route::post('auth/login', [AuthController::class, 'login'])
    ->middleware('throttle:6,1');

Route::post('auth/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

// Authenticated user profile
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public campaign endpoints
Route::get('campaigns', [CampaignController::class, 'index']);
Route::get('campaigns/{campaign}', [CampaignController::class, 'show']);

// Admin-only endpoints
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('campaigns', [CampaignController::class, 'store']);

    Route::match(
        ['put', 'patch'],
        'campaigns/{campaign}',
        [CampaignController::class, 'update']
    );

    Route::delete(
        'campaigns/{campaign}',
        [CampaignController::class, 'destroy']
    );

    Route::apiResource('donors', DonorController::class);

    Route::get('donations', [DonationController::class, 'index']);
    Route::get('donations/{donation}', [DonationController::class, 'show']);
    Route::post(
        'donations/{donation}/sync-status',
        [DonationController::class, 'syncStatus']
    );
});

// Public donation creation, with rate limiting
Route::post('donations', [DonationController::class, 'store'])
    ->middleware('throttle:10,1');

// Publicly reachable, but verifies Xendit's callback token
Route::post(
    'webhooks/xendit/invoice',
    [XenditWebhookController::class, 'handle']
)->middleware('throttle:60,1');