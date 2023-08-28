<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnrollmentController;


    Route::get('all_staff', [EnrollmentController::class, 'getStaff'])->middleware(['abilities:view-enrollment']);
    Route::post('enrollments', [EnrollmentController::class, 'create'])->middleware(['abilities:add-enrollment']);
    Route::get('enrollments', [EnrollmentController::class, 'index'])->middleware(['abilities:view-enrollment']);
    Route::get('enrollments/{id}', [EnrollmentController::class, 'show'])->middleware(['abilities:show-enrollment']);
    Route::put('enrollments/{id}', [EnrollmentController::class, 'update'])->middleware(['abilities:edit-enrollment']);
    Route::delete('enrollments/{id}', [EnrollmentController::class, 'delete'])->middleware(['abilities:delete-enrollment']);
    Route::get('get_school_owner', [EnrollmentController::class, 'getCanSchoolOwner'])->middleware(['abilities:edit-schools']);
    Route::get('list-school-admins', [EnrollmentController::class, 'listSchoolAdmins'])->middleware(['abilities:view-enrollment']);
    Route::post('add-school-admin', [EnrollmentController::class, 'addSchoolAdmin'])->middleware(['abilities:add-enrollment']);
    Route::delete('remove-school-admin', [EnrollmentController::class, 'removeSchoolAdmin'])->middleware(['abilities:edit-enrollment']);

