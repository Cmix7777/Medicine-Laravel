<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

Route::get('/', [MedicineController::class, 'home'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
Route::get('/medicines/{medicine}', [MedicineController::class, 'show'])->name('medicines.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Управление лекарствами - только для администраторов
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
    Route::post('/medicines', [MedicineController::class, 'store'])->name('medicines.store');
    Route::get('/medicines/{medicine}/edit', [MedicineController::class, 'edit'])->name('medicines.edit');
    Route::put('/medicines/{medicine}', [MedicineController::class, 'update'])->name('medicines.update');
    Route::delete('/medicines/{medicine}', [MedicineController::class, 'destroy'])->name('medicines.destroy');
});

// Корзина
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{medicine}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{medicine}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{medicine}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

// Заказы
Route::middleware('auth')->group(function () {
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
});

// Админ-панель
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.updateRole');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
});
