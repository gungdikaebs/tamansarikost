<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\GuestController;
use App\Http\Controllers\Dashboard\PenghuniController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTenantController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
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
    Route::get('/dashboard/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/dashboard/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/dashboard/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/dashboard/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::get('/dashboard/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
    Route::delete('/dashboard/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    // Room Tenants
    Route::post('/dashboard/room-tenants', [RoomTenantController::class, 'store'])->name('room-tenants.store');
    Route::delete('/dashboard/room-tenants/{id}', [RoomTenantController::class, 'destroy'])->name('room-tenants.destroy');
});

// === Users ===
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/dashboard/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/dashboard/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/dashboard/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/dashboard/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/dashboard/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// === Tenants ===
Route::middleware(['auth', 'isAdmin'])->group(
    function () {
        Route::get('/dashboard/tenants', [TenantController::class, 'index'])->name('tenants.index');
        Route::get('/dashboard/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
        Route::post('/dashboard/tenants', [TenantController::class, 'store'])->name('tenants.store');
        Route::get('/dashboard/tenants/{tenant}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
        Route::put('/dashboard/tenants/{tenant}', [TenantController::class, 'update'])->name('tenants.update');
        Route::delete('/dashboard/tenants/{tenant}', [TenantController::class, 'destroy'])->name('tenants.destroy');
    }
);
