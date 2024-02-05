<?php

namespace App\Services;

use App\Exceptions\CityNotFoundException;
use App\Models\City;
use Illuminate\Database\Eloquent\Collection;

class CityService
{
    /**
     * @throws CityNotFoundException
     */
    public function getCityFromName(string $cityName): City
    {
        // fetching city based on name provided
        $city = City::where('city_name', $cityName)->first();
        if (empty($city)) {
            throw new CityNotFoundException();
        }
        return $city;
    }

    /**
     * Function will return list of cities and coordinates
     */
    public static function getCityNames(string $query = '', int $limit = 5): Collection
    {
        return empty(trim($query)) ? City::all()->take(5)
                : City::whereRaw('LOWER(city_name) like "%?%"',[strtolower($query)])
                    ->orWhereRaw('LOWER(country) like "%?%"',[strtolower($query)])
                    ->limit($limit)->get();
    }

}
