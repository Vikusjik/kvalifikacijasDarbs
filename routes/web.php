<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\MyConsultationController;


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
    Route::post('/consultations/{consultation}/register', [ConsultationController::class, 'registerAndAssign'])->name('consultations.register.submit');
    Route::get('/consultations/{consultation}', [ConsultationController::class, 'show'])->name('consultations.show');

    
    Route::get('/my-consultations', [MyConsultationController::class, 'index'])->name('myConsultation.index');
    Route::post('my-consultations/{consultationId}/cancel', [MyConsultationController::class, 'cancel'])->name('myConsultation.cancel');
    Route::put('/my-consultations/{consultation}', [MyConsultationController::class, 'update'])->name('myConsultation.update');

    Route::get('/consultations/create', [ConsultationController::class, 'create'])->withoutMiddleware([\App\Http\Middleware\Authenticate::class]);

});

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::resource('consultations', ConsultationController::class);
Route::get('/consultations/{id}/register', [StudentController::class, 'registerForm'])->name('consultations.register.form');
Route::post('/consultations/{id}/register', [StudentController::class, 'registerSubmit'])->name('consultations.register.submit');

