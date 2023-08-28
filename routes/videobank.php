<?php
use Illuminate\Support\Facades\Route;

Route::get('videos','VideoBankController@index')->middleware(['abilities:view-video']);
Route::post('videos', 'VideoBankController@create')->middleware(['abilities:add-video']);
Route::put('videos/{id}', 'VideoBankController@update')->middleware(['abilities:edit-video']);
Route::delete('videos/{id}','VideoBankController@delete')->middleware(['abilities:delete-video']);
Route::get('videos/{id}','VideoBankController@show')->middleware(['abilities:view-video']);
Route::get('videos/{id}/remove-thumbnail','VideoBankController@removeThumbnail')->middleware(['abilities:delete-video']);


