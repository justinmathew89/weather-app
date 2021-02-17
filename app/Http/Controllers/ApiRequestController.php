<?php

namespace App\Http\Controllers;

use App\Models\CityList;
use App\Providers\CitynameServiceProvider;
use App\Providers\WeatherServiceProvider;
use Illuminate\Http\Request;

class ApiRequestController extends Controller
{
    public static function cityList()
    {
        $cityListProvider = new CitynameServiceProvider(app());
        return response($cityListProvider->getCityNames())
            ->header('Content-Type', 'JSON');
    }

    public function forecastList(Request $request)
    {
        $cityName = trim($request->get('cityname'));
        $cityId = trim($request->get('cityId'));
        $isValidCityName = CitynameServiceProvider::isValidCity($cityName);
        if ($cityName && $isValidCityName && empty($cityId))
        {
            $response = WeatherServiceProvider::getWeatherDatabyCityName($cityName);
        }
        else if ($cityName && $isValidCityName)
        {
            $response = WeatherServiceProvider::getWeatherData($cityName, $cityId);
        }
        return response($response)
            ->header('Content-Type', 'JSON');
    }
}
