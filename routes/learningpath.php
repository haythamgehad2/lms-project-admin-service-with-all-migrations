<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LearningPathController;

Route::get('learningpaths', [LearningPathController::class, 'index'])->middleware(['abilities:view-learningpath']);
Route::post('learningpaths', [LearningPathController::class, 'create'])->middleware(['abilities:add-learningpath']);
Route::put('learningpaths/{id}', [LearningPathController::class, 'update'])->middleware(['abilities:edit-learningpath']);
Route::delete('learningpaths/{id}', [LearningPathController::class, 'delete'])->middleware(['abilities:delete-learningpath']);
Route::get('learningpaths/{id}', [LearningPathController::class, 'show'])->middleware(['abilities:delete-learningpath']);
Route::put('manage-mission-learningpath', [LearningPathController::class, 'learningPathManageStatus'])->middleware(['abilities:manage-learningpath']);


