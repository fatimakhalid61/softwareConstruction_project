<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::post('/login',[\App\Http\Controllers\AuthController::class,'login']);
Route::post('/register',[\App\Http\Controllers\AuthController::class,'register']);

Route::resource('/appointments',\App\Http\Controllers\AppointmentController::class)
    ->middleware(\App\Http\Middleware\JWTMiddleware::class);
