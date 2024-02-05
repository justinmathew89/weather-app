<?php

namespace Services;

use App\Exceptions\WeatherDataNotFoundException;
use App\Models\City;
use App\Services\CityService;
use App\Services\WeatherService;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{

    public function testGetWeatherDataSuccess(): void
    {
        $cityService = $this->createConfiguredMock(CityService::class,[
            'getCityFromName' => $this->generateValidCity()
        ]);
        $weatherAPIResponse = $this->createConfiguredMock(Response::class,[
            'json' => [
                'current' => ['temp' => 20, 'feels_like' => 18, 'weather' => [['description' => 'Clear']]],
                'daily' => [
                    ['dt'=>1704070800,'temp' => ['min' => 15, 'max' => 25], 'wind_speed' => 10, 'weather' => [['description' => 'Sunny']]],
                    ['dt'=>1704157200,'temp' => ['min' => 15, 'max' => 25], 'wind_speed' => 10, 'weather' => [['description' => 'Sunny']]],
                    ['dt'=>1704243600,'temp' => ['min' => 15, 'max' => 25], 'wind_speed' => 10, 'weather' => [['description' => 'Sunny']]],
                    ['dt'=>1704330000,'temp' => ['min' => 15, 'max' => 25], 'wind_speed' => 10, 'weather' => [['description' => 'Sunny']]],
                    ['dt'=>1704416400,'temp' => ['min' => 15, 'max' => 25], 'wind_speed' => 10, 'weather' => [['description' => 'Sunny']]],
                    ['dt'=>1704502800,'temp' => ['min' => 15, 'max' => 25], 'wind_speed' => 10, 'weather' => [['description' => 'Sunny']]]
                ]
            ]
        ]);

        Http::shouldReceive('get')
            ->andReturn($weatherAPIResponse);
        $weatherService = new WeatherService($cityService);
        $weatherData = $weatherService->getWeatherofCity('Sydney');

        // Assert that the weather data is returned successfully
        $this->assertArrayHasKey('current_weather', $weatherData);
        $this->assertArrayHasKey('forecast_weather', $weatherData);
    }
    public function testGetWeatherDataThrowWeatherDataNotFoundExceptionOnAPIError(): void
    {
        $cityService = $this->createConfiguredMock(CityService::class,[
            'getCityFromName' => $this->generateValidCity()
        ]);
        $weatherAPIResponse = $this->createConfiguredMock(Response::class,[
            'json' => [
                'cod' => 400,
                'message' => 'Some Error occured'
            ]
        ]);

        Http::shouldReceive('get')
            ->andReturn($weatherAPIResponse);
        $weatherService = new WeatherService($cityService);
        $this->expectException(WeatherDataNotFoundException::class);
        $weatherService->getWeatherofCity('Sydney');
    }

    private function generateValidCity(): City
    {
        return new City([
            'city_name' => 'Sydney',
            'latitude' => 123.45,
            'longitude' => 123.45,
        ]);
    }
}
