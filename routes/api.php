<?php

use App\Http\Controllers\Api\TourGuideController;
use App\Http\Controllers\Api\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')
    ->name('api.')
    ->group(function () {
        Route::apiResource('trips', TripController::class)->only(['index', 'store', 'destroy', 'show', 'update']);
        Route::get('trip/get-available-resources', [TripController::class, 'getAvailableResources'])->name('trips.get-available-resources');

        Route::apiResource('tour-guides', TourGuideController::class)->only(['index', 'store', 'destroy', 'show', 'update']);
    });
