<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\LogController;



// Route untuk halaman utama (membawa ke dashboard)
Route::get('/', [TodolistController::class, 'index'])->name('dashboard');

// ------------------------
// AUTH ROUTES (LOGIN, REGISTER, LOGOUT)
// ------------------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ------------------------
// USER ROUTES (HANYA UNTUK ROLE "user")
// ------------------------

// Untuk semua user yang login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [TodolistController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    Route::put('/profile/update', [UserController::class, 'update'])->name('profile.update');

    // Todolist
    Route::get('/todolist/create', [TodolistController::class, 'create'])->name('todolist.create');
    Route::post('/todolist/store', [TodolistController::class, 'store'])->name('todolist.store');
    Route::get('/todolist/{id}', [TodolistController::class, 'show'])->name('todolist.show');
    Route::get('/todolist/{id}/edit', [TodolistController::class, 'edit'])->name('todolist.edit');
    Route::put('/todolist/{id}', [TodolistController::class, 'update'])->name('todolist.update');
    Route::delete('/todolist/{id}', [TodolistController::class, 'destroy'])->name('todolist.destroy');
    Route::patch('/todolist/{id}/status', [TodolistController::class, 'updateStatus'])->name('todolist.updateStatus');

    // Statistik
    Route::get('/statistic', [StatisticController::class, 'index'])->name('statistic.index');
});

// Hanya untuk admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/admin/logs', [LogController::class, 'index'])->name('admin.logs.index');

    //Route::get('/admin/logs', [AdminController::class, 'activityLogs'])->name('admin.logs');
});

