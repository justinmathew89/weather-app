<?php

namespace App\Providers;

use App\Models\CityList;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

/**
 * Class WeatherServiceProvider
 * @package App\Providers
 */
class WeatherServiceProvider extends ServiceProvider
{
    const API_URL_FORECAST = 'http://api.openweathermap.org/data/2.5/onecall';
    const API_KEY = 'a82ac8e27853a4c36788cf270563705e';
    const API_VALUE_UNIT = 'metric';
    const DEFAULT_CITY = 'Sydney';

    /**
     * Function will return weather data as array
     * The returened array contains current weather, todays forecast and forecast for next 5 days
     * @param $cityName
     * @param $cityId
     * @return array
     */
    public static function getWeatherData($cityName, $cityId)
    {
        // fetching the city details
        $city = CityList::where('city_name', $cityName)
            ->where('id', $cityId)
            ->first();

        // failing when city is not present
        if (!$city)
        {
            return [
                'status_code' => 1,
                'message' => 'Unable to locate city'
            ];
        }

        // fetching weather data
        $weatherData = Http::get(self::API_URL_FORECAST,[
            'appid' => self::API_KEY,
            'lat' => $city->latitude,
            'lon' => $city->longitude,
            'units' => self::API_VALUE_UNIT,
            'exclude' => 'hourly,minutely',
        ])->json();

        // formatting todays and current weather information
        $currentWeather = [];
        $currentWeather['currentTemperature'] = $weatherData['current']['temp'];
        $currentWeather['currentTemperatureFeelsLike'] = $weatherData['current']['feels_like'];
        $currentWeather['weather'] = $weatherData['current']['weather'][0]['description'];

        $currentWeather['minTemperature'] = $weatherData['daily'][0]['temp']['min'];
        $currentWeather['maxTemperature'] = $weatherData['daily'][0]['temp']['max'];
        $currentWeather['windspeed'] = $weatherData['daily'][0]['wind_speed'];

        // formatting next 5 days weather information
        $forecastWeather = [];
        for($i = 0; $i < 5; $i++)
        {
            $forecastWeather[] = [
                'date' => Date('d M', $weatherData['daily'][$i+1]['dt']),
                'minTemperature' => $weatherData['daily'][$i+1]['temp']['min'],
                'maxTemperature' => $weatherData['daily'][$i+1]['temp']['max'],
                'windspeed' => $weatherData['daily'][$i+1]['wind_speed'],
                'weather' => $weatherData['daily'][$i+1]['weather'][0]['description']
            ];
        }

        return [
            'status_code' => 0,
            'message' => 'Success',
            'current_weather' => $currentWeather,
            'forecast_weather' => $forecastWeather
        ];
    }

    /**
     * Function to fetch weather data from city Names
     * taking city name as an argument, it fetches the coordinates of first city
     * in case of more than one cities with same name
     * @param $cityName String
     * @return array
     */
    public static function getWeatherDataByCityName($cityName)
    {
        // fetching city based on name provided
        $city = CityList::where('city_name', $cityName)
            ->first();
        return self::getWeatherData($city->city_name, $city->id);
    }
}
