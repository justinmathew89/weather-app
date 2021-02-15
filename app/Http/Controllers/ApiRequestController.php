<?php

namespace App\Http\Controllers;

use App\Models\CityList;
use App\Providers\CitynameServiceProvider;
use Illuminate\Http\Request;

class ApiRequestController extends Controller
{
    public function cityList()
    {
        $cityListProvider = new CitynameServiceProvider(app());
        return response($cityListProvider->getCityNames())
            ->header('Content-Type', 'JSON');
    }

    public function cityListMatch($param)
    {
        $cityListProvider = new CitynameServiceProvider(app());
        return response($cityListProvider->getCityNamesMatch($param))
            ->header('Content-Type', 'JSON');
    }

    public function forecastList()
    {

    }

}
