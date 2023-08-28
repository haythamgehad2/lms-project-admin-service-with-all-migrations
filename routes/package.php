<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('packages', [PackageController::class, 'index'])->middleware(['abilities:view-packages']);
    Route::post('packages', [PackageController::class, 'create'])->middleware(['abilities:add-packages']);
    Route::put('packages/{id}', [PackageController::class, 'update'])->middleware(['abilities:edit-packages']);
    Route::delete('packages/{id}', [PackageController::class, 'delete'])->middleware(['abilities:delete-packages']);
    Route::get('packages/{id}', [PackageController::class, 'show'])->middleware(['abilities:show-packages']);

});
