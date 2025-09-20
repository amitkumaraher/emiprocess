<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\EmiController;

Route::middleware(['auth'])->group(function () {
    Route::get('/emi', [EmiController::class, 'index'])->name('emi.index');
    Route::post('/emi/process', [EmiController::class, 'process'])->name('emi.process');
});

require __DIR__.'/auth.php';
