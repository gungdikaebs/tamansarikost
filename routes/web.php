<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\DashboardController;
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
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('dashboard.admin');
        // Room Management
        Route::resource('rooms', RoomController::class)->except(['show']);
        Route::get('rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
        // Room Tenant Management
        Route::post('room-tenants', [RoomTenantController::class, 'store'])->name('room-tenants.store');
        Route::delete('room-tenants/{id}', [RoomTenantController::class, 'destroy'])->name('room-tenants.destroy');
        // User Management
        Route::resource('users', UserController::class)->except(['show']);
        // Tenant Management
        Route::resource('tenants', TenantController::class)->except(['show']);
    });

    // Penghuni Routes
    Route::middleware('role:penghuni')->group(function () {
        Route::get('/penghuni', [PenghuniController::class, 'index'])->name('dashboard.penghuni');
        Route::post('book-room/{roomId}', [PenghuniController::class, 'bookRoom'])->name('book.room');
        Route::get('register-tenant', [PenghuniController::class, 'createTenant'])->name('tenant.register');
        Route::post('register-tenant', [PenghuniController::class, 'storeTenant'])->name('tenant.register.store');
        Route::get('register-room-tenant', [PenghuniController::class, 'createRoomTenant'])->name('roomTenant.register');
        Route::post('register-room-tenant', [PenghuniController::class, 'storeRoomTenant'])->name('roomTenant.register.store');
    });
});





// == Payment ==
