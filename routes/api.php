<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Funcionalidad Logout con el controller de AuthController 'logout'
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Funcionalidad Register
Route::post('/register', [AuthController::class, 'register']);

//Funcionalidad Login
Route::post('/login', [AuthController::class, 'login']);