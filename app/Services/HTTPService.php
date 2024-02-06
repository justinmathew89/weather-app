<?php

namespace App\Services;

use App\Exceptions\CityNotFoundException;
use App\Exceptions\WeatherDataNotFoundException;
use App\Models\City;
use App\Services\Interfaces\HTTPServiceInterface;
use http\Client\Response;
use Illuminate\Support\Facades\Http;

class HTTPService implements HTTPServiceInterface
{
    /**
     * @inheritDoc
     */
    public function get(string $url, array $params): array
    {
        return Http::get($url, $params)->json();
    }
}
