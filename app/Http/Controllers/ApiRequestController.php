<?php

namespace App\Http\Controllers;

use App\Exceptions\CityNotFoundException;
use App\Exceptions\WeatherDataNotFoundException;
use App\Http\Requests\CityForecastRequest;
use App\Repository\CityRepository;
use App\Services\HTTPService;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;
use Illuminate\Log\Logger;

class ApiRequestController extends Controller
{

    private $weatherService;
    private $cityRepository;
    private $logger;

    public function __construct(
        WeatherService $weatherService,
        CityRepository $cityRepository,
        Logger      $logger
    )
    {
        $this->weatherService = $weatherService;
        $this->cityRepository = $cityRepository;
        $this->logger = $logger;
    }

    /**
     * Function to fetch cities list
     * Returns details of 5 cities for initial display in dropdown
     */
    public function cityList(): JsonResponse
    {
        return new JsonResponse($this->citySearch());
    }

    /**
     * Function to fetch city names based on the user input
     * @param $query String
     */
    public function citySearch(string $query = ''): JsonResponse
    {
        $returnArray = [];
        $cities =  $this->cityRepository->getCityNames($query);
        foreach($cities as $city)
        {
            $this->logger->info($city);
            $returnArray[] = [
                'label' => $city['city_name'].', '.$city['country'],
                'city' => $city['city_name'],
                'country' => $city['country'],
                'value' => $city['id']
            ];
        }
        return new JsonResponse($returnArray);
    }

    /**
     * Function that fetches the weather data based on user selection
     */
    public function forecastList(CityForecastRequest $request): JsonResponse
    {
        $cityName = data_get($request, 'cityname');

        try {
            $response = $this->weatherService->getWeatherofCity($cityName);
        } catch (CityNotFoundException $e) {
            $response = [
                'code' => 1,
                'message' => 'Invalid City details provided: ' . $cityName
            ];
        } catch (WeatherDataNotFoundException $e) {
            $response = [
                'code' => 1,
                'message' => 'Unable to find weather data for the city : ' . $cityName
            ];
        } catch (\Exception $e) {
            $response = [
                'code' => 1,
                'message' => 'Some error occured : ' . $e->getMessage()
            ];
        }

        return new JsonResponse($response);
    }
}
