<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::middleware('auth:api')->group(function () {
    Route::get('projects', [ProjectController::class, 'index']);
    Route::post('projects', [ProjectController::class, 'store']);
    Route::get('projects/{projectUuid}', [ProjectController::class, 'show']);
    Route::put('projects/{projectUuid}', [ProjectController::class, 'update']);
    Route::delete('projects/{projectUuid}', [ProjectController::class, 'destroy']);
});

Route::middleware('auth:api')->group(function () {

    Route::get(
        'projects/{projectUuid}/tasks',
        [TaskController::class, 'index']
    );

    Route::post(
        'projects/{projectUuid}/tasks',
        [TaskController::class, 'store']
    );

    Route::get(
        'projects/{projectUuid}/tasks/{taskUuid}',
        [TaskController::class, 'show']
    );

    Route::put(
        'projects/{projectUuid}/tasks/{taskUuid}',
        [TaskController::class, 'update']
    );

    Route::delete(
        'projects/{projectUuid}/tasks/{taskUuid}',
        [TaskController::class, 'destroy']
    );
});
