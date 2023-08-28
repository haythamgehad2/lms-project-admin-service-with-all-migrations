<?php

use App\Http\Controllers\RewardActionController;
use Illuminate\Support\Facades\Route;

Route::controller(RewardActionController::class)
->prefix("reward-actions")
->group(function () {
    Route::get("/", "index")->middleware(['abilities:view-reward-actions']);
    Route::get("/{id}", "show")->middleware(['abilities:show-reward-actions']);
    Route::put("/{id}", "update")->middleware(['abilities:edit-reward-actions']);
});
