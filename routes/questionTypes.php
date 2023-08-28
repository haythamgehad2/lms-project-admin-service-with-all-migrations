<?php

use App\Http\Controllers\QuestionTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;

    Route::get('question_types', [QuestionTypeController::class, 'index'])->middleware(['abilities:view-questionType']);
    Route::post('question_types', [QuestionTypeController::class, 'create'])->middleware(['abilities:add-questionType']);
    Route::put('question_types/{id}', [QuestionTypeController::class, 'update'])->middleware(['abilities:edit-questionType']);
    Route::delete('question_types/{id}', [QuestionTypeController::class, 'delete'])->middleware(['abilities:delete-questionType']);
    Route::get('question_types/{id}', [QuestionTypeController::class, 'show'])->middleware(['abilities:view-questionType']);
