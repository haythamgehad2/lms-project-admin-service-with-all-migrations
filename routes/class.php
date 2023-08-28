<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('classes', [ClassController::class, 'index'])->middleware(['abilities:view-classes']);
    Route::post('classes', [ClassController::class, 'create'])->middleware(['abilities:add-classes']);
    Route::put('classes/{id}', [ClassController::class, 'update'])->middleware(['abilities:edit-classes']);
    Route::delete('classes/{id}', [ClassController::class, 'delete'])->middleware(['abilities:delete-classes']);
    Route::get('classes/{id}', [ClassController::class, 'show'])->middleware(['abilities:show-classes']);

});
