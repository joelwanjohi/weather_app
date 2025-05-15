<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Get current weather data for a location
     */
    public function getCurrentWeather(Request $request): JsonResponse
    {
        $city = $request->query('city', 'Nairobi');
        $units = $request->query('units', 'metric');
        
        $weatherData = $this->weatherService->getCurrentWeather($city, $units);
        
        return response()->json($weatherData);
    }

    /**
     * Get forecast weather data for a location
     */
    public function getForecast(Request $request): JsonResponse
    {
        $city = $request->query('city', 'Nairobi');
        $units = $request->query('units', 'metric');
        
        $forecastData = $this->weatherService->getForecast($city, $units);
        
        return response()->json($forecastData);
    }
    
    /**
     * Get all weather data (current and forecast) for a location
     */
    public function getAllWeatherData(Request $request): JsonResponse
    {
        $city = $request->query('city', 'Nairobi');
        $units = $request->query('units', 'metric');
        
        $current = $this->weatherService->getCurrentWeather($city, $units);
        $forecast = $this->weatherService->getForecast($city, $units);
        
        return response()->json([
            'current' => $current,
            'forecast' => $forecast
        ]);
    }
}