<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('countries', [CountryController::class, 'index'])->middleware(['abilities:view-countries']);
    Route::post('countries', [CountryController::class, 'create'])->middleware(['abilities:add-countries']);
    Route::put('countries/{id}', [CountryController::class, 'update'])->middleware(['abilities:edit-countries']);
    Route::delete('countries/{id}', [CountryController::class, 'delete'])->middleware(['abilities:delete-countries']);
    Route::get('countries/{id}', [CountryController::class, 'show'])->middleware(['abilities:delete-countries']);

});
