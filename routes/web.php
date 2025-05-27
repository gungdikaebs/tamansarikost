<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\GuestController;
use App\Http\Controllers\Dashboard\PenghuniController;
use App\Http\Controllers\RoomController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('Index');
})->name('Index');


// Auth
Route::get('/register', [RegisterController::class, 'index'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


// === Dashboard ===
// Admin
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('dashboard.admin');
});
// Penghuni
Route::middleware(['auth', 'isPenghuni'])->group(function () {
    Route::get('/dashboard/penghuni', [PenghuniController::class, 'index'])->name('dashboard.penghuni');
});
// Guest
Route::middleware(['auth', 'isGuest'])->group(function () {
    Route::get('/dashboard/guest', [GuestController::class, 'index'])->name('dashboard.guest');
});
// Dashboard Global
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// === Rooms ===
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::post('/dashboard/rooms', [RoomController::class, 'store'])->name('rooms.store');
    // Delete Room
    Route::delete('/dashboard/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
});
