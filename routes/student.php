<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentClassController;

    Route::get('all_students', [StudentClassController::class, 'getStudents'])->middleware(['abilities:view-enrollment']);
    Route::post('class_students', [StudentClassController::class, 'create'])->middleware(['abilities:add-enrollment']);
    Route::get('class_students', [StudentClassController::class, 'index'])->middleware(['abilities:view-enrollment']);
    Route::get('class_students/{id}', [StudentClassController::class, 'show'])->middleware(['abilities:show-enrollment']);
    Route::put('class_students/{id}', [StudentClassController::class, 'update'])->middleware(['abilities:edit-enrollment']);
    Route::delete('class_students/{id}', [StudentClassController::class, 'delete'])->middleware(['abilities:delete-enrollment']);
