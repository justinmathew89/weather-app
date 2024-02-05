<?php

namespace App\Exceptions;

class WeatherDataNotFoundException extends \Exception
{
    protected $message = "Unable to find weather data foe the city";
}
