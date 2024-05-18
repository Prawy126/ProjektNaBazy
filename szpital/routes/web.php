<?php
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicinController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/zaloguj', function () {
    return view('Logowanie');
});

// Poprawione trasy
Route::get('/lekarzeTab', [DoctorController::class, 'index'])->name('doctorIndex');
Route::post('/lekarzeTab', [DoctorController::class, 'store'])->name('doctorStore');
Route::get('/edycjaLekarze/{id}', [DoctorController::class, 'edit'])->name('doctorEdit');
Route::put('/lekarzeTab/{id}', [DoctorController::class, 'update'])->name('doctorUpdate');
Route::delete('/lekarzeTab/{id}', [DoctorController::class, 'destroy'])->name('doctorDelete');

Route::get('/pielegniarkiTab', [NurseController::class, 'index'])->name('nurseIndex');
Route::get('/pacjenciTab', [PatientController::class, 'index'])->name('patientIndex');
Route::get('/lekiTab', [MedicinController::class, 'index'])->name('medicinIndex');
Route::get('/saleTab', [RoomController::class, 'index'])->name('roomIndex');

Route::get('/pacjenciTab', function () {
    return view('pacjenciTab');
})->name('pacjenciTab');



Route::get('/admin', function() {
    return view('admin');
})->name('admin');

Route::get('/edycjaLekarze', function() {
    return view('edycjaLekarze');
})->name('doctorsEdit');
