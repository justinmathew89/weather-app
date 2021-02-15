<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = dirname(__FILE__) . '/worldcities.csv';
        $file_handle = fopen($csv, "r");

        $successCount = 0;

        while (!feof($file_handle))
        {
            $line = fgetcsv($file_handle);
            if (empty($line))
            {
                continue;
            }
            if ($line[0] == 'city_name')
            {
                continue;
            }

            $city =[];
            $city['city_name'] = $line[0];
            $city['latitude'] = floatval($line[1]);
            $city['longitude'] = floatval($line[2]);
            $city['country'] = $line[3];

            // insert to table
            if (DB::table('city_lists')->insert($city))
            {
                $successCount ++;
            }

        }
        fclose($file_handle);
        echo 'Successfully inserted '.$successCount.' city records';
    }
}
