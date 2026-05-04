<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::post('/reservation', [ReservationController::class, 'store']);
    Route::post('/reservation/{reservation}/cancel', [ReservationController::class, 'cancel']);
});
