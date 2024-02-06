<?php

namespace App\Services\Interfaces;

use App\Exceptions\CityNotFoundException;
use App\Exceptions\WeatherDataNotFoundException;
use App\Models\City;

interface WeatherServiceInterface
{
    /**
     * Function to fetch weather data from city Names
     * taking city name as an argument, it fetches the coordinates of first city
     * in case of more than one city with same name
     * @throws CityNotFoundException | WeatherDataNotFoundException
     */
    public function getWeatherofCity(string $cityName): array;
}
