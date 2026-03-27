<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GymClassController;
use App\Http\Controllers\ReservationController;

Route::apiResource('clases', GymClassController::class);
Route::apiResource('reservas', ReservationController::class);