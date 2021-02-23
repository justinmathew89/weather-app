<?php

namespace App\Http\Controllers;

use App\Models\CityList;
use App\Providers\CitynameServiceProvider;
use App\Providers\WeatherServiceProvider;
use Illuminate\Http\Request;

class ApiRequestController extends Controller
{
    /**
     * Function to fetch cities list
     * Returns details of 5 cities for initial display in dropdown
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function cityList()
    {
        return response(CitynameServiceProvider::getCityNames())
            ->header('Content-Type', 'JSON');
    }

    /**
     * Function to fetch city names based on the user input
     * @param $query String
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function citySearch($query)
    {
        if (!empty(trim($query)))
        {
            return response(CitynameServiceProvider::searchCityNames($query))
                ->header('Content-Type', 'JSON');
        }
        else
        {
            $this->cityList();
        }
    }

    /**
     * Function that fetches the weather data based on user selection
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function forecastList(Request $request)
    {
        $cityName = trim($request->get('cityname'));
        $cityId = trim($request->get('cityId'));
        $isValidCityName = CitynameServiceProvider::isValidCity($cityName);

        if ($cityName && $isValidCityName && empty($cityId)) // Fetching the weather details based on user selection
        {
            $response = WeatherServiceProvider::getWeatherDatabyCityName($cityName);
        }
        else if ($cityName && $isValidCityName) //weather info of default city Sydney
        {
            $response = WeatherServiceProvider::getWeatherData($cityName, $cityId);
        }
        else //error input
        {
            $response = [
                'code' => 1,
                'message' => 'Invalid City details provided'
            ];
        }
        return response($response)
            ->header('Content-Type', 'JSON');
    }
}
