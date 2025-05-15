<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.openweathermap.org/data/2.5/';
    
    public function __construct()
    {
        $this->apiKey = env('OPENWEATHERMAP_API_KEY');
    }
    
    /**
     * Get current weather for a location
     * 
     * @param string $city City name
     * @param string $units Units (metric, imperial)
     * @return array Weather data
     */
    public function getCurrentWeather(string $city, string $units = 'metric'): array
    {
        $cacheKey = "weather_current_{$city}_{$units}";
        
        return Cache::remember($cacheKey, 1800, function () use ($city, $units) {
            try {
                $response = Http::get($this->baseUrl . 'weather', [
                    'q' => $city,
                    'units' => $units,
                    'appid' => $this->apiKey
                ]);
                
                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'temperature' => $data['main']['temp'],
                        'description' => $data['weather'][0]['main'],
                        'icon' => $data['weather'][0]['icon'],
                        'humidity' => $data['main']['humidity'] ?? 0,
                        'wind_speed' => $data['wind']['speed'] ?? 0,
                        'city' => $data['name'],
                        'country' => $data['sys']['country'] ?? '',
                        'date' => now()->format('jS M Y'),
                    ];
                }
                
                return ['error' => 'Failed to fetch weather data'];
            } catch (\Exception $e) {
                Log::error('Weather API Error: ' . $e->getMessage());
                return ['error' => 'Failed to fetch weather data'];
            }
        });
    }
    
    /**
     * Get weather forecast for a location
     * 
     * @param string $city City name
     * @param string $units Units (metric, imperial)
     * @return array Forecast data
     */
    public function getForecast(string $city, string $units = 'metric'): array
    {
        $cacheKey = "weather_forecast_{$city}_{$units}";
        
        return Cache::remember($cacheKey, 1800, function () use ($city, $units) {
            try {
                $response = Http::get($this->baseUrl . 'forecast', [
                    'q' => $city,
                    'units' => $units,
                    'appid' => $this->apiKey
                ]);
                
                if ($response->successful()) {
                    $data = $response->json();
                    $forecasts = [];
                    
                    // Process forecast data to get next 3 days
                    $dailyForecasts = $this->processForecasts($data['list']);
                    
                    // Only get next 3 days
                    $forecasts = array_slice($dailyForecasts, 0, 3);
                    
                    return [
                        'city' => $data['city']['name'],
                        'forecasts' => $forecasts
                    ];
                }
                
                return ['error' => 'Failed to fetch forecast data'];
            } catch (\Exception $e) {
                Log::error('Weather API Error: ' . $e->getMessage());
                return ['error' => 'Failed to fetch forecast data'];
            }
        });
    }
    
    /**
     * Process forecast data to get daily forecasts
     * 
     * @param array $forecastList List of forecast points
     * @return array Daily forecasts
     */
    private function processForecasts(array $forecastList): array
    {
        $dailyForecasts = [];
        $currentDay = '';
        
        foreach ($forecastList as $forecast) {
            $date = date('Y-m-d', $forecast['dt']);
            
            if ($date === date('Y-m-d')) {
                continue; // Skip current day
            }
            
            if ($currentDay !== $date) {
                $currentDay = $date;
                
                // Find min/max temperatures for the day
                $minTemp = PHP_FLOAT_MAX;
                $maxTemp = PHP_FLOAT_MIN;
                $icon = '';
                $description = '';
                
                // Find min/max temps for this day
                foreach ($forecastList as $f) {
                    if (date('Y-m-d', $f['dt']) === $date) {
                        $minTemp = min($minTemp, $f['main']['temp_min']);
                        $maxTemp = max($maxTemp, $f['main']['temp_max']);
                        
                        // Use midday forecast for the icon/description
                        if (date('H', $f['dt']) >= 12 && date('H', $f['dt']) <= 14 && empty($icon)) {
                            $icon = $f['weather'][0]['icon'];
                            $description = $f['weather'][0]['main'];
                        }
                    }
                }
                
                // If we didn't find a midday icon, use the first one
                if (empty($icon)) {
                    foreach ($forecastList as $f) {
                        if (date('Y-m-d', $f['dt']) === $date) {
                            $icon = $f['weather'][0]['icon'];
                            $description = $f['weather'][0]['main'];
                            break;
                        }
                    }
                }
                
                $dailyForecasts[] = [
                    'date' => date('j M', strtotime($date)),
                    'min_temp' => round($minTemp),
                    'max_temp' => round($maxTemp),
                    'icon' => $icon,
                    'description' => $description
                ];
                
                if (count($dailyForecasts) >= 3) {
                    break;
                }
            }
        }
        
        return $dailyForecasts;
    }
}