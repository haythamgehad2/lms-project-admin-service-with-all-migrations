<?php

use App\Http\Controllers\StudentActionHistoryController;
use Illuminate\Support\Facades\Route;

Route::controller(StudentActionHistoryController::class)
->prefix("student-action-histories")
->group(function () {
    Route::get("/", "index")->middleware(['abilities:view-student-action-histories']);
    Route::get("/student/{studentId}", "studentIndex")->middleware(['abilities:view-student-action-histories']);
    Route::get("/{id}", "show")->middleware(['abilities:show-student-action-histories']);
});
