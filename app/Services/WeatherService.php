<?php

namespace App\Services;

use App\Exceptions\CityNotFoundException;
use App\Exceptions\WeatherDataNotFoundException;
use App\Models\City;
use App\Repository\CityRepository;
use App\Services\Interfaces\WeatherServiceInterface;

class WeatherService implements WeatherServiceInterface
{

    const API_URL_FORECAST = 'http://api.openweathermap.org/data/2.5/onecall';
    const API_KEY = 'a82ac8e27853a4c36788cf270563705e';
    const API_VALUE_UNIT = 'metric';
    const DEFAULT_CITY = 'Sydney';

    private $cityRepository;
    private $HTTPService;

    public function __construct(
        CityRepository $cityRepository,
        HTTPService $HTTPService
    )
    {
        $this->cityRepository = $cityRepository;
        $this->HTTPService = $HTTPService;
    }

    /**
     * Function will return weather data as array
     * @throws WeatherDataNotFoundException
     */
    private function getWeatherData(City $city): array
    {
        $weatherData = $this->HTTPService->get(self::API_URL_FORECAST,[
            'APPID' => self::API_KEY,
            'lat' => $city['latitude'],
            'lon' => $city['longitude'],
            'units' => self::API_VALUE_UNIT,
            'exclude' => 'hourly,minutely',
        ]);

        if (array_key_exists('cod', $weatherData) && array_key_exists('message', $weatherData)) {
            throw new WeatherDataNotFoundException();
        }

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
     * @inheritDoc
     */
    public function getWeatherofCity(string $cityName): array
    {
        $city = $this->cityRepository->getCityFromName($cityName);
        if (empty($city)) {
            throw new CityNotFoundException();
        }
        return $this->getWeatherData($city);
    }

}
