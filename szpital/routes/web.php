<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/zaloguj', function () {
    return view('Logowanie');
});

Route::get('/lekarzeTab', function () {
    return view('lekarzeTab');
});

Route::get('/pielegniarkiTab', function () {
    return view('pielegniarkiTab');
});

Route::get('/pacjenciTab', function () {
    return view('pacjenciTab');
});

Route::get('/lekiTab', function () {
    return view('lekiTab');
});

Route::get('/saleTab', function () {
    return view('saleTab');
});

Route::get('/admin', function() {
    return view('admin');
}); //admin autoryzacja

