<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DardaniaPageController;
use App\Http\Controllers\DardaniaBookingController;

Route::get('/', [DardaniaPageController::class, 'home'])->name('home');
Route::post('/booking', [DardaniaBookingController::class, 'store'])->name('booking.store');
