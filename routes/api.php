<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BinSensorController;

Route::post('/bins/update-sensor', [BinSensorController::class, 'updateFromSensor']);
