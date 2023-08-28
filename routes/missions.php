<?php
use Illuminate\Support\Facades\Route;

    Route::get('missions','MissionController@index')->middleware(['abilities:view-missions']);
    Route::get('missions/{id}','MissionController@show')->middleware(['abilities:view-missions']);
    Route::get('missions/{id}/full-details','MissionController@fullDetails')->middleware(['abilities:show-missions,show-questions']);
    Route::post('missions', 'MissionController@create')->middleware(['abilities:add-missions']);
    Route::put('missions/{id}', 'MissionController@update')->middleware(['abilities:edit-missions']);
    Route::delete('missions/{id}','MissionController@delete')->middleware(['abilities:delete-missions']);
    Route::delete('duplicate_missions/{id}','MissionController@duplicateMission')->middleware(['abilities:duplicate-missions']);
    Route::post('rearrange-mission','MissionController@rearrangeMissions')->middleware(['abilities:rearrange-missions']);
    Route::get('mission/{id}/learningpaths','MissionController@missionLearningPath')->middleware(['abilities:manage-learningpath']);
    Route::get('mission-path-contents','MissionController@missionLearningPathContent')->middleware(['abilities:manage-content']);
    Route::put('handel-mission-contents','MissionController@handelLearningPathContent')->middleware(['abilities:manage-content']);




