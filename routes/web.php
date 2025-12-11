<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\AuthController;

Route::get('/', [MedicineController::class, 'home'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
Route::get('/medicines/{medicine}', [MedicineController::class, 'show'])->name('medicines.show');

Route::middleware('auth')->group(function () {
    Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
    Route::post('/medicines', [MedicineController::class, 'store'])->name('medicines.store');
    Route::get('/medicines/{medicine}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');
    Route::put('/medicines/{medicine}', [MedicineController::class, 'update'])->name('medicines.update');
    Route::delete('/medicines/{medicine}', [MedicineController::class, 'destroy'])->name('medicines.destroy');
});
