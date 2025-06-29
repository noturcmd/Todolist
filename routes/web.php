<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodolistController;

// Halaman awal
Route::get('/', function () {
    return view('dashboard');
});

// Login & Register
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Semua route yang butuh login
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [TodolistController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');

    // Todolist
    Route::get('/todolist/create', [TodolistController::class, 'create'])->name('todolist.create');
    Route::post('/todolist/store', [TodolistController::class, 'store'])->name('todolist.store');
    Route::get('/todolist/{id}', [TodolistController::class, 'show'])->name('todolist.show');
    Route::get('/todolist/{id}/edit', [TodolistController::class, 'edit'])->name('todolist.edit');
    Route::put('/todolist/{id}', [TodolistController::class, 'update'])->name('todolist.update');
    Route::delete('/todolist/{id}', [TodolistController::class, 'destroy'])->name('todolist.destroy');

    Route::patch('/todolist/{id}/status', [TodolistController::class, 'updateStatus'])->name('todolist.updateStatus');

});
