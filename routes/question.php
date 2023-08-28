<?php

use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('questions', [QuestionController::class, 'index'])->middleware(['abilities:view-questions']);
Route::post('questions', [QuestionController::class, 'create'])->middleware(['abilities:add-questions']);
Route::put('questions/{id}', [QuestionController::class, 'update'])->middleware(['abilities:edit-questions']);
Route::delete('questions/{id}', [QuestionController::class, 'delete'])->middleware(['abilities:delete-questions']);
Route::get('questions/{id}', [QuestionController::class, 'show'])->middleware(['abilities:view-questions']);
Route::get('questions/{id}/full-details', [QuestionController::class, 'fullDetails'])->middleware(['abilities:show-questions']);
