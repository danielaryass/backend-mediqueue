<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('user', UserController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('doctor', DoctorController::class);
    Route::resource('appointment', AppointmentController::class);
    Route::post('appointment/{id}/missing', [AppointmentController::class, 'missing'])->name('appointment.missing');
    Route::post('appointment/{id}/done', [AppointmentController::class, 'done'])->name('appointment.done');
});
