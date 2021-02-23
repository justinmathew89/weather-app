<?php

namespace App\Console\Commands;

use App\Providers\CitynameServiceProvider;
use App\Providers\WeatherServiceProvider;
use Illuminate\Console\Command;

class FetchCityWeatherInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetchweather {cityNames}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate weather info from the list of cities entered.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cityNamesList = $this->argument('cityNames');
        $successCount = 0;
        $errorCount = 0;
        if (!empty($cityNamesList))
        {
            $cityNames = explode(',', $cityNamesList);
            $file = fopen('public/weather.csv','w');

            // setting the title info
            $titleLine = [
                'City',
                'Date',
                'Min Temp(C)',
                'Max Temp(C)',
                'Weather'
            ];
            fputcsv($file,$titleLine);
            foreach ($cityNames as $city)
            {
                $weatherData = [];
                if (CitynameServiceProvider::isValidCity($city))
                {
                    $weatherData = WeatherServiceProvider::getWeatherDataByCityName($city);
                    if (!empty($weatherData))
                    {
                        // Adding current weather info
                        $todaysWeather = [
                            $city,
                            Date('d M', strtotime('today')),
                            $weatherData['current_weather']['minTemperature'],
                            $weatherData['current_weather']['maxTemperature'],
                            $weatherData['current_weather']['weather'],
                        ];
                        fputcsv($file, $todaysWeather);

                        // Adding the forecast weather details
                        $DayCnt = 1;
                        foreach ($weatherData['forecast_weather'] as $forecastWeather)
                        {
                            $forecast = [
                                $city,
                                Date('d M', strtotime('today '. $DayCnt . ' day')),
                                $forecastWeather['minTemperature'],
                                $forecastWeather['maxTemperature'],
                                $forecastWeather['weather'],
                            ];
                            fputcsv($file, $forecast);
                            $DayCnt++;
                        }
                    }
                    // incrementing success count
                    $successCount++;
                }
                else
                {
                    // incrementing error count
                    $errorCount++;
                }
            }
            fclose($file);
            echo "Successfully imported weather data of $successCount cites and $errorCount error occured";
        }
        else
        {
            echo 'City Names not provided';
        }
    }
}
