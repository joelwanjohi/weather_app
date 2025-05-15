<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/weather/current', [WeatherController::class, 'getCurrentWeather']);
Route::get('/weather/forecast', [WeatherController::class, 'getForecast']);
Route::get('/weather', [WeatherController::class, 'getAllWeatherData']);

// Enable CORS
Route::options('/{any}', function() {
    return response('', 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
})->where('any', '.*');