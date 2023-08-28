<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolTypeController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('school-types', [SchoolTypeController::class, 'index'])->middleware(['abilities:view-schoolTypes']);
    Route::post('school-types', [SchoolTypeController::class, 'create'])->middleware(['abilities:add-schoolTypes']);
    Route::put('school-types/{id}', [SchoolTypeController::class, 'update'])->middleware(['abilities:edit-schoolTypes']);
    Route::delete('school-types/{id}', [SchoolTypeController::class, 'delete'])->middleware(['abilities:delete-schoolTypes']);
    Route::get('school-types/{id}', [SchoolTypeController::class, 'show'])->middleware(['abilities:view-schoolTypes']);
});
