<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController; // pastikan ini ada


Route::get('/', function () {
    return view('dashboard');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Route::get('/login', function () {
//     return view('login_page');
// });
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/profile', [UserController::class, 'showProfile'])->name('profile')->middleware('auth');
Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update')->middleware('auth');


