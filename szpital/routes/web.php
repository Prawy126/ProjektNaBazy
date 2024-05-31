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
Route::get('/leakrzeTab/{id}/edycjaLeakrze', [DoctorController::class, 'edit'])->name('doctorEdit');
Route::put('/lekarzeTab/{id}', [DoctorController::class, 'update'])->name('doctorUpdate');
Route::delete('/lekarzeTab/{id}', [DoctorController::class, 'destroy'])->name('doctorDelete');

Route::get('/pielegniarkiTab', [NurseController::class, 'index'])->name('nurseIndex');
Route::post('/nurses', [NurseController::class, 'store'])->name('nursesStore');
Route::get('/nurses/{id}', [NurseController::class, 'show'])->name('nursesShow');
Route::put('/nurses/{id}', [NurseController::class, 'update'])->name('nursesUpdate');
Route::delete('/nurses/{id}', [NurseController::class, 'destroy'])->name('nursesDestroy');

Route::get('/pacjenciTab', [PatientController::class, 'index'])->name('patientIndex');

Route::get('/lekiTab', [MedicinController::class, 'index'])->name('medicinIndex');
Route::post('/lekiTab', [MedicinController::class, 'store'])->name('medicinStore');
Route::get('/lekiTab/{id}/edycjaLeki', [MedicinController::class, 'edit'])->name('medicinEdit');
Route::put('/lekiTab/{id}', [MedicinController::class, 'update'])->name('medicinUpdate');
Route::delete('/lekiTab/{id}', [MedicinController::class, 'destroy'])->name('medicinDelete');

Route::get('/saleTab', [RoomController::class, 'index'])->name('roomIndex');
Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('roomsShow');
Route::post('/rooms', [RoomController::class, 'store'])->name('roomsStore');
Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('roomsUpdate');
Route::delete('/rooms/{id}', [RoomController::class, 'destroy'])->name('roomsDestroy');

Route::get('/pacjenciTab', function () {
    return view('pacjenciTab');
})->name('pacjenciTab');

Route::get('/admin', function() {
    return view('admin');
})->name('admin');

