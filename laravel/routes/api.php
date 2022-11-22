<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdmController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Routes for authenticated
Route::middleware('auth:sanctum')->group(function() {

    Route::get('/index', [UserController::class, 'index']);
    Route::put('/reserve', [UserController::class, 'reserve']);

    Route::post('/createBarber', [AdmController::class, 'createBarber']);
    Route::post('/createHour', [AdmController::class, 'createHour']);


});

// Routes publics
Route::post('/createUser', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'login']);
