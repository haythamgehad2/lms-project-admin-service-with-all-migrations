<?php
use App\Http\Controllers\LanguageMethodController;
use Illuminate\Support\Facades\Route;

    Route::get('language_methods', [LanguageMethodController::class, 'index'])->middleware(['abilities:view-languageMethod']);
    Route::post('language_methods', [LanguageMethodController::class, 'create'])->middleware(['abilities:add-languageMethod']);
    Route::put('language_methods/{id}', [LanguageMethodController::class, 'update'])->middleware(['abilities:edit-languageMethod']);
    Route::delete('language_methods/{id}', [LanguageMethodController::class, 'delete'])->middleware(['abilities:delete-languageMethod']);
    Route::get('language_methods/{id}', [LanguageMethodController::class, 'show'])->middleware(['abilities:view-languageMethod']);
