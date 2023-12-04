<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/users',[UserController::class, 'register']);
Route::post('/users/login',[UserController::class, 'login']);

Route::get('/doctors', [DoctorController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'get']);
    Route::post('/adduser', [UserController::class, 'addUser']);
    Route::patch('/users', [UserController::class, 'update']);
    Route::post('/users/logout', [UserController::class, 'logout']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
    Route::post('/doctors', [DoctorController::class, 'addDoctor']);
    Route::get('/doctors/user', [DoctorController::class, 'getUserWithRoleDoctor']);
    Route::patch('/doctors/{id}', [DoctorController::class, 'editDoctor']);
    Route::get('/doctors/{id}', [DoctorController::class, 'getDetailDoctor']);
    Route::post('/appointments', [AppointmentController::class, 'createAppointment']);
    Route::get('/appointments', [AppointmentController::class, 'getAppointment']);
    Route::patch('/appointments/setmissing/{id}', [AppointmentController::class, 'setStatusToMissing']);
    Route::patch('/appointments/setcompleted/{id}', [AppointmentController::class, 'setStatusToCompleted']);
    Route::get('/appointments/{id}', [AppointmentController::class, 'getDetailAppointment']);
    Route::get('/allappointments', [AppointmentController::class, 'getAllAppointment']);
    
    
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
