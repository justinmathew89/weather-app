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
    public function getCityNames()
    {
        $returnArray = [];
        $cities = CityList::all()->take(5);
        foreach($cities as $cityList)
        {
            $returnArray[] = [
                'label' => $cityList->city_name,
                'value' => $cityList->id
            ];
        }
        return $returnArray;
    }

    public static function isValidCity($cityName)
    {
        return CityList::where('city_name', $cityName)
                ->count() === 1;
    }
}
