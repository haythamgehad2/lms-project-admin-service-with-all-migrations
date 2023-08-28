<?php

use App\Http\Controllers\QuestionDifficultyController;
use Illuminate\Support\Facades\Route;

Route::get('question_difficulties', [QuestionDifficultyController::class, 'index'])->middleware(['abilities:view-questionDifficulty']);
Route::post('question_difficulties', [QuestionDifficultyController::class, 'create'])->middleware(['abilities:add-questionDifficulty']);
Route::put('question_difficulties/{id}', [QuestionDifficultyController::class, 'update'])->middleware(['abilities:edit-questionDifficulty']);
Route::delete('question_difficulties/{id}', [QuestionDifficultyController::class, 'delete'])->middleware(['abilities:delete-questionDifficulty']);
Route::get('question_difficulties/{id}', [QuestionDifficultyController::class, 'show'])->middleware(['abilities:view-questionDifficulty']);
Route::put('question_difficulties/{id}/points', [QuestionDifficultyController::class, 'updatePoints'])->middleware(['abilities:edit-questionDifficulty']);
