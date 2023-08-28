<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('roles', [RoleController::class, 'index'])->middleware(['abilities:view-roles']);
    Route::post('roles', [RoleController::class, 'create'])->middleware(['abilities:add-roles']);
    Route::put('roles/{id}', [RoleController::class, 'update'])->middleware(['abilities:edit-roles']);
    Route::delete('roles/{id}', [RoleController::class, 'delete'])->middleware(['abilities:delete-roles']);
    Route::get('roles/{id}', [RoleController::class, 'show'])->middleware(['abilities:view-roles']);
});
