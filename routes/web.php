<?php

use Illuminate\Support\Facades\Route;


// All web URL's loading the home page
Route::get(
    '/{cityName}',
    [\App\Http\Controllers\WeatherController::class, 'homePage']
)->where('cityName', '.*');
