<?php

use App\Http\Controllers\BloomCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('bloom_categories', [BloomCategoryController::class, 'index'])->middleware(['abilities:view-bloomCategory']);
Route::post('bloom_categories', [BloomCategoryController::class, 'create'])->middleware(['abilities:add-bloomCategory']);
Route::put('bloom_categories/{id}', [BloomCategoryController::class, 'update'])->middleware(['abilities:edit-bloomCategory']);
Route::delete('bloom_categories/{id}', [BloomCategoryController::class, 'delete'])->middleware(['abilities:delete-bloomCategory']);
Route::get('bloom_categories/{id}', [BloomCategoryController::class, 'show'])->middleware(['abilities:view-bloomCategory']);
