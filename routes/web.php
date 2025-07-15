<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PenghuniController;

use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\RoomTenantController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Penghuni\RegistrationController;

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
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        // Tenant Management
        Route::resource('tenants', TenantController::class)->except(['show']);
        // Payment Management
        Route::resource('payments', PaymentController::class)->except(['show']);
        Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::put('payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.updateStatus');
    });

    // Penghuni Routes
    Route::middleware('role:penghuni')->group(function () {
        Route::get('/penghuni', [PenghuniController::class, 'index'])->name('dashboard.penghuni');
        Route::get('register-tenant', [RegistrationController::class, 'showRegisterFormTenant'])->name('penghuni.register');
        Route::post('register-tenant', [RegistrationController::class, 'storeTenant'])->name('penghuni.register.store');
        Route::get('register-payment', [RegistrationController::class, 'showRegisterFormPayment'])->name('penghuni.register-payment');
        Route::post('register-payment', [RegistrationController::class, 'storeRegisterPayment'])->name('penghuni.register-payment.store');
    });
});





// == Payment ==
