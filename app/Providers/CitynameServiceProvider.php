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
                'value' => $cityList->latitude.','.$cityList->longitude
            ];
        }
        return $returnArray;
    }

    /**
     * @param $param
     * @return array
     */
    public function getCityNamesMatch($param)
    {
        $returnArray = [];
        $cities = CityList::all()->take(5);
        foreach($cities as $cityList)
        {
            $returnArray[] = [
                'label' => $cityList->city_name,
                'value' => $cityList->latitude.','.$cityList->longitude
            ];
        }
        return $returnArray;
    }
}
