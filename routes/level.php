<?php
use Illuminate\Support\Facades\Route;

    Route::get('levels','LevelController@index')->middleware(['abilities:view-levels']);
    Route::get('levels/{id}','LevelController@show')->middleware(['abilities:view-levels']);
    Route::post('levels', 'LevelController@create')->middleware(['abilities:add-levels']);
    Route::put('levels/{id}', 'LevelController@update')->middleware(['abilities:edit-levels']);
    Route::delete('levels/{id}','LevelController@delete')->middleware(['abilities:delete-levels']);

    Route::get('levels/{id}/missions','LevelController@showSchoolLevels')->middleware(['abilities:show-mission-levels']);


