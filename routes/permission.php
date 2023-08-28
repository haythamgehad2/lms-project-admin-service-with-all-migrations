<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('permissions', [PermissionController::class, 'index'])->middleware(['abilities:view-permissions']);
    Route::post('permissions', [PermissionController::class, 'create'])->middleware(['abilities:add-permissions']);
    Route::put('permissions/{id}', [PermissionController::class, 'update'])->middleware(['abilities:edit-permissions']);
    Route::delete('permissions/{id}', [PermissionController::class, 'delete'])->middleware(['abilities:delete-permissions']);
});
