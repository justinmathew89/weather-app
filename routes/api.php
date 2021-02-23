<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// api route to fetch initial city list
Route::get('/city', [\App\Http\Controllers\ApiRequestController::class, 'cityList']);
// api route to fetch cities based on search input
Route::get('/city/{query}', [\App\Http\Controllers\ApiRequestController::class, 'citySearch']);
// api route to fetch weather forecast info
Route::get('/forecast/', [\App\Http\Controllers\ApiRequestController::class, 'forecastList']);
