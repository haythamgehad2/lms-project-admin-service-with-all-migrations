<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'register'])->middleware(['abilities:add-users']);
    Route::get('/users/current', [UserController::class, 'getAuthenticatedUser']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('refresh', [UserController::class, 'refresh']);
    Route::post('change-password', [UserController::class, 'changePassword']);
    Route::post('activate-user', [UserController::class, 'activateUser']);
    Route::post('excel-user-import', [UserController::class, 'importExcelUser']);
    Route::post('temp-import-users', [UserController::class, 'tmpExcelUserImport']);

});
