<?php

namespace App\Console\Commands;

use App\Exceptions\CityNotFoundException;
use App\Exceptions\WeatherDataNotFoundException;
use App\Services\WeatherService;
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

    private $weatherService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        WeatherService $weatherService
    )
    {
        $this->weatherService = $weatherService;
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
                try {
                    $weatherData = $this->weatherService->getWeatherofCity($city);
                } catch (CityNotFoundException | WeatherDataNotFoundException $e) {
                    $errorCount++;
                    continue;
                }
                if (!empty($weatherData))
                {
                    $successCount++;
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
                } else {
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
