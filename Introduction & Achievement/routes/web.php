<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/ecops/site', [PageController::class, 'site']);
Route::get('/ecops/introduction', [PageController::class, 'introduction']);
Route::get('/ecops/achievement', [PageController::class, 'achievement']);
