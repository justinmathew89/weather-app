<?php

namespace App\Providers;

use App\Models\CityList;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class CitynameServiceProvider extends ServiceProvider
{

    /**
     * Function will return list of cities and coordinates
     *
     * @return array
     */
    public static function getCityNames()
    {
        $returnArray = [];
        $cities = CityList::all()->take(5);
        foreach($cities as $cityList)
        {
            $returnArray[] = [
                'label' => $cityList->city_name.', '.$cityList->country,
                'city' => $cityList->city_name,
                'country' => $cityList->country,
                'value' => $cityList->id
            ];
        }
        return $returnArray;
    }

    /**
     * Function to fetch city names based on search query by user
     * @param $query
     * @return array
     */
    public static function searchCityNames($query)
    {
        $returnArray = [];
        $cities = CityList::where('city_name','LIKE','%'.trim($query).'%')
            ->orWhere('country', 'LIKE','%'.$query.'%')
            ->limit(5)->get();
        // formatting the response
        foreach($cities as $cityList)
        {
            $returnArray[] = [
                'label' => $cityList->city_name.', '.$cityList->country,
                'city' => $cityList->city_name,
                'country' => $cityList->country,
                'value' => $cityList->id
            ];
        }
        return $returnArray;
    }

    /**
     * A check if the city name provided by the user is valid
     * @param $cityName
     * @return bool
     */
    public static function isValidCity($cityName)
    {
        return CityList::where('city_name', $cityName)
                ->count() >= 1;
    }
}
