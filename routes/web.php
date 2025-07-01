<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodolistController;

// Route untuk halaman utama (membawa ke dashboard)
Route::get('/', [TodolistController::class, 'index'])->name('dashboard');

// Login & Register Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Logout Route
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Middleware untuk pengecekan cookie 'user_email' pada setiap route
Route::middleware(['check.user_email'])->group(function () {
    // Route untuk dashboard dan semua fitur yang memerlukan login
    Route::get('/dashboard', [TodolistController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');

    // Routes untuk Todo List
    Route::get('/todolist/create', [TodolistController::class, 'create'])->name('todolist.create');
    Route::post('/todolist/store', [TodolistController::class, 'store'])->name('todolist.store');
    Route::get('/todolist/{id}', [TodolistController::class, 'show'])->name('todolist.show');
    Route::get('/todolist/{id}/edit', [TodolistController::class, 'edit'])->name('todolist.edit');
    Route::put('/todolist/{id}', [TodolistController::class, 'update'])->name('todolist.update');
    Route::delete('/todolist/{id}', [TodolistController::class, 'destroy'])->name('todolist.destroy');
    Route::patch('/todolist/{id}/status', [TodolistController::class, 'updateStatus'])->name('todolist.updateStatus');
});
