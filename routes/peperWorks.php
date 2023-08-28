<?php
use Illuminate\Support\Facades\Route;

Route::get('peper_works','PeperworkController@index')->middleware(['abilities:view-paperWork']);
Route::post('peper_works', 'PeperworkController@create')->middleware(['abilities:add-paperWork']);
Route::put('peper_works/{id}', 'PeperworkController@update')->middleware(['abilities:edit-paperWork']);
Route::delete('peper_works/{id}','PeperworkController@delete')->middleware(['abilities:delete-paperWork']);
Route::get('peper_works/{id}','PeperworkController@show')->middleware(['abilities:view-paperWork']);
Route::delete('peper_works/{id}/remove_file','PeperworkController@deleteFile')->middleware(['abilities:view-paperWork']);
Route::put('peper_works/{id}/uplode_file','PeperworkController@uplodeFile')->middleware(['abilities:view-paperWork']);


