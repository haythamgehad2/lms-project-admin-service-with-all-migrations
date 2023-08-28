<?php
use Illuminate\Support\Facades\Route;

Route::get('themes','ThemeController@index')->middleware(['abilities:view-themes']);
Route::post('themes', 'ThemeController@create')->middleware(['abilities:add-themes']);
Route::put('themes/{id}', 'ThemeController@update')->middleware(['abilities:edit-themes']);
Route::delete('themes/{id}','ThemeController@delete')->middleware(['abilities:delete-themes']);
Route::get('themes/{id}','ThemeController@show')->middleware(['abilities:view-themes']);
