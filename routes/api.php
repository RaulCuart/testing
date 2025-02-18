<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Funcionalidad Logout con el controller de AuthController 'logout'
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
//Funcionalidad Register
Route::post('/register', [AuthController::class, 'register']);
//Funcionalidad Login
Route::post('/login', [AuthController::class, 'login']);
//Funcionalidad de DamController
Route::get('/dams',[DamController::class,'index']);
Route::get('/dams/{id}',[DamController::class,'show']);
Route::post('/dams',[DamController::class,'store'])->middleware('auth:sanctum');
Route::post('/dams',[DamController::class,'store']);
Route::put('/dams/{id}',[DamController::class,'update']);
Route::delete('/dams/{id}',[DamController::class,'destroy']);
//Funcionalidad de body

//Post = crear
//Put = modificar
//get obtener datos