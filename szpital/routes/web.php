<?php

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/zaloguj', function () {
    return view('Logowanie');
});

Route::post('/lekarzeTab', [DoctorController::class, 'show'])->name('doctorShow');

Route::get('/pielegniarkiTab', function () {
    return view('pielegniarkiTab');
})->name('pielegniarkiTab');

Route::get('/pacjenciTab', function () {
    return view('pacjenciTab');
})->name('pacjenciTab');

Route::get('/lekiTab', function () {
    return view('lekiTab');
})->name('lekiTab');

Route::get('/saleTab', function () {
    return view('saleTab');
})->name('saleTab');

Route::get('/admin', function() {
    return view('admin');
})->name('admin');



