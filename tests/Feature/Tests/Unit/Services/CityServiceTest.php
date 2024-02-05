<?php

namespace Tests\Unit\Services;

use App\Exceptions\CityNotFoundException;
use App\Models\City;
use App\Services\CityService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class CityServiceTest extends TestCase
{
    use RefreshDatabase; // This will refresh the database before each test

    /**
     * @throws CityNotFoundException
     */
    public function testGetCityFromNameFound()
    {
        // Create a mock City object
        $city = new City([
            'city_name' => 'Test City',
            'latitude' => 123.45,
            'longitude' => 123.45,
            'country' => 'country',
        ]);

        $mockCity = Mockery::mock(City::class);
        $mockCity->shouldReceive('where')->with('city_name', 'Test City')->andReturnSelf();
        $mockCity->shouldReceive('first')->andReturn($city);

        $cityService = new CityService();

        // Call the getCityFromName method
        $result = $cityService->getCityFromName('Test City');

        // Assert that the result matches the mock City object
        $this->assertEquals($city, $result);
    }

    public function testGetCityFromNameThrowsNotFoundException()
    {

        $mockCity = Mockery::mock(City::class);
        $mockCity->shouldReceive('where')->with('city_name', 'Nonexistent City')->andReturnSelf(); // Return a query builder instance
        $mockCity->shouldReceive('first')->andReturnNull(); // Return a mock City instance

        // Create an instance of CityService
        $cityService = new CityService();

        // Expect a CityNotFoundException to be thrown
        $this->expectException(CityNotFoundException::class);

        // Call the getCityFromName method with a nonexistent city
        $cityService->getCityFromName('Nonexistent City');
    }

    public function testGetCityNamesWithoutQuery()
    {
        // Create some mock cities
        $cities = $this->createCities();

        // Mock the City model to return the mock cities
        $mockCityModel = $this->mock(City::class);
        $mockCityModel->shouldReceive('all')->andReturn($cities);

        // Create an instance of CityService
        $cityService = new CityService();

        // Call the getCityNames method without a query
        $result = $cityService->getCityNames();

        // Assert that the result is a collection of cities with a limit of 5
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(5, $result);
    }

    public function testGetCityNamesWithQuery()
    {
        // Create some mock cities
        $cities = $this->createCities();

        // Mock the City model to return the mock cities
        $mockCityModel = $this->mock(City::class);
        $mockCityModel->shouldReceive('limit')->andReturn($cities);

        // Create an instance of CityService
        $cityService = new CityService();

        // Call the getCityNames method with a query
        $result = $cityService->getCityNames('Test');

        // Assert that the result is a collection of cities filtered by the query with a limit of 5
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(5, $result);
    }

    private function createCities(): array
    {
        $cities = [];
        for($cityCount = 1; $cityCount<5; $cityCount++) {
            $cities[] = new City([
                'city_name' => 'Test City '.$cityCount,
                'latitude' => 123.45,
                'longitude' => 123.45,
                'country' => 'country'.$cityCount,
            ]);
        }
        return $cities;
    }
}
