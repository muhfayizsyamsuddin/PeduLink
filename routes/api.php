<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\DonorController;
use App\Http\Controllers\Api\DonationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('campaigns', CampaignController::class);
Route::apiResource('donors', DonorController::class);
Route::post('donations', [DonationController::class, 'store']);