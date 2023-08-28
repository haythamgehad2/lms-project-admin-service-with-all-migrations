<?php

use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

    Route::get('quizzes', [QuizController::class, 'index'])->middleware(['abilities:view-quizzes']);
    Route::post('quizzes', [QuizController::class, 'create'])->middleware(['abilities:add-quizzes']);
    Route::put('quizzes/{id}', [QuizController::class, 'update'])->middleware(['abilities:edit-quizzes']);
    Route::delete('quizzes/{id}', [QuizController::class, 'delete'])->middleware(['abilities:delete-quizzes']);
    Route::get('quizzes/{id}', [QuizController::class, 'show'])->middleware(['abilities:view-quizzes']);
    Route::get('quizzes_question_difficulty', [QuizController::class, 'questionDifficultyList'])->middleware(['abilities:view-quizzes']);
    Route::post('make_random_questions', [QuizController::class, 'getRandomQuestion'])->middleware(['abilities:view-quizzes']);


