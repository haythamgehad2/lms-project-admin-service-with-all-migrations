<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('schools', [SchoolController::class, 'index'])->middleware(['abilities:view-schools']);
    Route::post('schools', [SchoolController::class, 'create'])->middleware(['abilities:add-schools']);
    Route::put('schools/{id}', [SchoolController::class, 'update'])->middleware(['abilities:edit-schools']);
    Route::delete('schools/{id}', [SchoolController::class, 'delete'])->middleware(['abilities:delete-schools']);
    Route::post('attach_school_levels',[SchoolController::class, 'schoolLevels'])->middleware(['abilities:view-levels']);
    Route::post('attach_school_terms',[SchoolController::class, 'schoolTerms'])->middleware(['abilities:view-levels']);
    Route::get('school/{id}/levels-terms', [SchoolController::class, 'schoolLevelTerm'])->middleware(['abilities:delete-schools']);
    Route::get('schools/{id}', [SchoolController::class, 'show'])->middleware(['abilities:show-schools']);
    Route::get('my-school-info', [SchoolController::class, 'mySchoolInfoResource'])->middleware(['abilities:view-schools']);


});
