<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class WeatherServiceProvider extends ServiceProvider
{
    const API_URL_FORECAST = 'http://api.openweathermap.org/data/2.5/onecall';
    const API_KEY = 'a82ac8e27853a4c36788cf270563705e';
    const API_VALUE_UNIT = 'metric';
    const DEFAULT_CITY = 'Sydney';

    /*
     * Function will return weather data
     */
    public function getWeatherData($state = self::DEFAULT_CITY)
    {
        return Http::get(self::API_URL_FORECAST,[
            'appid' => self::API_KEY,
            'q' => $state,
            'units' => self::API_VALUE_UNIT,
            'exclude' => 'hourly,minutely',
        ])->json();
    }
}
