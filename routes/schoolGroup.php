<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolGroupController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('school-groups', [SchoolGroupController::class, 'index'])->middleware(['abilities:view-schoolGroups']);
    Route::post('school-groups', [SchoolGroupController::class, 'create'])->middleware(['abilities:add-schoolGroups']);
    Route::put('school-groups/{id}', [SchoolGroupController::class, 'update'])->middleware(['abilities:edit-schoolGroups']);
    Route::delete('school-groups/{id}', [SchoolGroupController::class, 'delete'])->middleware(['abilities:delete-schoolGroups']);

    Route::get('school-groups/{id}', [SchoolGroupController::class, 'show'])->middleware(['abilities:view-schoolGroups']);
    Route::get('school-groups/{id}/full-details', [SchoolGroupController::class, 'fullDetails'])->middleware(['abilities:view-schoolGroups']);
});
