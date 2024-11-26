<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

// Autentificēšanās un verifikācija
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
   
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('students.dashboard');
});


Route::middleware(['auth'])->group(function () {
  
    Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');
    Route::post('/consultations/{id}/register', [ConsultationController::class, 'register'])->name('consultations.register');
});


Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::resource('consultations', ConsultationController::class);
