<?php

use App\Http\Controllers\Api\ActivityLevelController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NutritionGoalController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/health', function () {
        return response()->json([
            'success' => true,
            'message' => 'Calorie Calc API is running.',
            'timestamp' => now()->toISOString(),
        ]);
    });

    Route::post('/auth/register', [AuthController::class, 'register'])
        ->middleware('throttle:10,1');

    Route::post('/auth/login', [AuthController::class, 'login'])
        ->middleware('throttle:10,1');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::post('/auth/logout-all', [AuthController::class, 'logoutAll']);

        Route::get('/activity-levels', [ActivityLevelController::class, 'index']);

        Route::get('/profile', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);

        Route::get('/nutrition-goal', [NutritionGoalController::class, 'show']);
        Route::post('/nutrition-goal', [NutritionGoalController::class, 'store']);
    });
});