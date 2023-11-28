<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::get('/unauthorized', function(){
    return response()->json([
        'errors' => [
                    'message' => [
                        'unauthorized'
                    ]
    ]], 401);
})->name('unauthorized');
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users', [UserController::class, 'get']);
    Route::post('/adduser', [UserController::class, 'addUser']);
});
