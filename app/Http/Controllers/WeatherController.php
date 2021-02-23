<?php

namespace App\Http\Controllers;

use App\Providers\CitynameServiceProvider;

class WeatherController extends Controller
{
    /*
     * Home page controller
     */
    public function homePage($request = null)
    {
        return view('welcome');
    }
}
