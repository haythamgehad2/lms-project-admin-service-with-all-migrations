<?php

use App\Http\Controllers\JeelLevelXpController;
use Illuminate\Support\Facades\Route;

Route::controller(JeelLevelXpController::class)
->prefix("jeel-level-xps")
->group(function () {
    Route::get("/", "index")->middleware(['abilities:view-jeel-level-xp']);
    Route::get("/{id}", "show")->middleware(['abilities:show-jeel-level-xp']);
    Route::put("/{id}", "update")->middleware(['abilities:edit-jeel-level-xp']);
});
