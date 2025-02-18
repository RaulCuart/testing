<?php

use App\Http\Controllers\DamControllerWebRoutes;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DamController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/dams',[DamControllerWebRoutes::class,'getDamsFromApi']);

Route::get('/dams/{id}',[DamControllerWebRoutes::class,'getDamByIdFromApi']);
Route::get('/damsToDestroy/{id}',[DamControllerWebRoutes::class,'deleteDamByIdFromApi']);
Route::get('/damsToUpdate/{id}',[DamControllerWebRoutes::class,'updateDamByIdFromApi']);
Route::get('/damsToCreate',[DamControllerWebRoutes::class,'createDamWithJsonBodyReqFromAPI']);
Route::get('/damsToCreateBearer',[DamControllerWebRoutes::class,'createDamWithBearerJsonBodyReqFromAPI']);

Route::resource('dams',DamControllerWebRoutes::class);
require __DIR__.'/auth.php';
