<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TermController;

    Route::get('terms', [TermController::class, 'index'])->middleware(['abilities:view-terms']);
    Route::post('terms', [TermController::class, 'create'])->middleware(['abilities:add-terms']);
    Route::put('terms/{id}', [TermController::class, 'update'])->middleware(['abilities:edit-terms']);
    Route::delete('terms/{id}', [TermController::class, 'delete'])->middleware(['abilities:delete-terms']);
    Route::get('terms/{id}', [TermController::class, 'show'])->middleware(['abilities:show-terms']);

