<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PredictionController::class, 'showForm'])->name('home');
Route::post('/predict', [PredictionController::class, 'predict'])->name('predict.crime');
Route::get('/statistik', [PredictionController::class, 'showStatistics'])->name('statistics');
Route::get('/statistik/{lokasi}', [PredictionController::class, 'showLocationDetail'])->name('location.detail');
Route::get('/about', [PredictionController::class, 'showAbout'])->name('about');
Route::get('/contact', [PredictionController::class, 'showContact'])->name('contact');

// Rute baru untuk peramalan
Route::get('/forecast', [PredictionController::class, 'showForecastForm'])->name('forecast.form');
Route::post('/forecast', [PredictionController::class, 'forecast'])->name('forecast.submit');