<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/unauthorized', [UserController::class, 'unauthorized'])->name('unauthorized');
