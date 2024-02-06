<?php

namespace Tests\Unit\Services;

use App\Exceptions\CityNotFoundException;
use App\Exceptions\WeatherDataNotFoundException;
use App\Models\City;
use App\Repository\CityRepository;
use App\Services\HTTPService;
use App\Services\WeatherService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{

    public function testGetWeatherDataSuccess(): void
    {
        $cityRepositoryMock = $this->createConfiguredMock(CityRepository::class,[
            'getCityFromName' => $this->generateValidCity()
        ]);
        $httpServiceMock = $this->createConfiguredMock(HTTPService::class,[
            'get' => $this->getValidClimateData()
        ]);

        $weatherService = new WeatherService($cityRepositoryMock, $httpServiceMock);
        $weatherData = $weatherService->getWeatherofCity('Sydney');

        // Assert that the weather data is returned successfully
        $this->assertArrayHasKey('current_weather', $weatherData);
        $this->assertArrayHasKey('forecast_weather', $weatherData);
    }
    public function testGetWeatherDataThrowWeatherDataNotFoundExceptionOnApiError(): void
    {
        $cityRepositoryMock = $this->createConfiguredMock(CityRepository::class,[
            'getCityFromName' => $this->generateValidCity()
        ]);
        $httpServiceMock = $this->createConfiguredMock(HTTPService::class,[
            'get' => [
                'cod' => 400,
                'message' => 'Some Error occured'
            ]
        ]);

        $weatherService = new WeatherService($cityRepositoryMock, $httpServiceMock);
        $this->expectException(WeatherDataNotFoundException::class);
        $weatherService->getWeatherofCity('Sydney');
    }
    public function testGetWeatherDataThrowCityNotFoundExceptionOnInvalidCity(): void
    {
        $cityRepositoryMock = $this->createConfiguredMock(CityRepository::class,[
            'getCityFromName' => null
        ]);
        $httpServiceMock = $this->createConfiguredMock(HTTPService::class,[
            'get' => $this->getValidClimateData()
        ]);

        $weatherService = new WeatherService($cityRepositoryMock, $httpServiceMock);
        $this->expectException(CityNotFoundException::class);
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

    private function getValidClimateData(): array
    {
        return [
            'current' => ['temp' => 20, 'feels_like' => 18, 'weather' => [['description' => 'Clear']]],
            'daily' => [
                ['dt'=>1704070800,'temp' => ['min' => 15, 'max' => 25], 'wind_speed' => 10, 'weather' => [['description' => 'Sunny']]],
                ['dt'=>1704157200,'temp' => ['min' => 15, 'max' => 25], 'wind_speed' => 10, 'weather' => [['description' => 'Sunny']]],
                ['dt'=>1704243600,'temp' => ['min' => 15, 'max' => 25], 'wind_speed' => 10, 'weather' => [['description' => 'Sunny']]],
                ['dt'=>1704330000,'temp' => ['min' => 15, 'max' => 25], 'wind_speed' => 10, 'weather' => [['description' => 'Sunny']]],
                ['dt'=>1704416400,'temp' => ['min' => 15, 'max' => 25], 'wind_speed' => 10, 'weather' => [['description' => 'Sunny']]],
                ['dt'=>1704502800,'temp' => ['min' => 15, 'max' => 25], 'wind_speed' => 10, 'weather' => [['description' => 'Sunny']]]
            ]
        ];
    }
}
