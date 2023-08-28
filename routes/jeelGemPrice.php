<?php

use App\Http\Controllers\JeelGemPriceController;
use Illuminate\Support\Facades\Route;

Route::controller(JeelGemPriceController::class)
->prefix("jeel-gem-prices")
->group(function () {
    Route::get("/", "index")->middleware(['abilities:view-jeel-gem-prices']);
    Route::get("/{id}", "show")->middleware(['abilities:show-jeel-gem-prices']);
    Route::put("/{id}", "update")->middleware(['abilities:edit-jeel-gem-prices']);
});
