<?php

namespace App\Http\Controllers;

use App\Providers\CitynameServiceProvider;

class WeatherController extends Controller
{
    /*
     * Home page controller
     * If the URL doesn't have any parameters, the city name will be defaulted to Sydney
     */
    public function homePage($request = null)
    {
        return view('welcome');
//        $weatherProvider = new CitynameServiceProvider(app());
//        $weatherData = $weatherProvider->getWeatherData($request);
//        $weatherData = $weatherProvider->getCityName($request);
//        dd($weatherData);
//        foreach($weatherData['list'] as $weather)
//        {
//            echo date("Y-m-d H:i:s", $weather['dt']). ', '. $weather['main']['temp'];
////            print_r($weather);
//            echo "<br>";
//        }
    }
}
