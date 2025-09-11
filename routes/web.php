<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ComplaintController;
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
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Penghuni\AnnouncementPenghuniController;
use App\Http\Controllers\Penghuni\ComplaintPenghuniController;
use App\Http\Controllers\Penghuni\RegistrationController;
use App\Http\Controllers\Penghuni\PaymentPenghuniController;
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
    Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('dashboard.admin');
        // Room Management
        Route::resource('rooms', RoomController::class)->except(['show']);
        Route::get('rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
        // Room Tenant Management
        Route::resource('room-tenants', RoomTenantController::class)->except(['show']);
        // User Management
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        // Tenant Management
        Route::resource('tenants', TenantController::class)->except(['show']);
        // Payment Management
        Route::resource('payments', PaymentController::class)->except(['show']);
        Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::put('payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.updateStatus');
        // Complaint Management
        Route::resource('complaints', ComplaintController::class)->except(['show]']);
        Route::get('complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
        Route::put('complaints/{complaint}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');
        // Announcements Management
        Route::resource('announcements', AnnouncementController::class)->except(['show']);
        Route::get('announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
        // Reports Management
        Route::resource('reports', ReportController::class)->except(['show']);
    });

    // Penghuni Routes
    Route::middleware('role:penghuni')->group(function () {
        // Dashboard
        Route::get('/penghuni', [PenghuniController::class, 'index'])->name('dashboard.penghuni');
        // Register for First Time
        Route::get('register-tenant', [RegistrationController::class, 'showRegisterFormTenant'])->name('penghuni.register');
        Route::post('register-tenant', [RegistrationController::class, 'storeTenant'])->name('penghuni.register.store');
        Route::get('register-payment', [RegistrationController::class, 'showRegisterFormPayment'])->name('penghuni.register-payment');
        Route::post('register-payment', [RegistrationController::class, 'storeRegisterPayment'])->name('penghuni.register-payment.store');
        // Payment Page
        Route::get('payment', [PaymentPenghuniController::class, 'index'])->name('penghuni.payment');
        Route::get('payment/bayar/{id}', [PaymentPenghuniController::class, 'submitPayment'])->name('penghuni.payment.submit');
        Route::post('payment', [PaymentPenghuniController::class, 'updatePayment'])->name('penghuni.payment.store');
        Route::get('payment/detail/{id}', [PaymentPenghuniController::class, 'showPaymentForm'])->name('penghuni.payment.detail');
        // Information
        Route::get('informations', [AnnouncementPenghuniController::class, 'index'])->name('penghuni.informations');
        Route::get('informations/detail/{id}', [AnnouncementPenghuniController::class, 'show'])->name('penghuni.informations.detail');
        // Complaint
        Route::get('complaint', [ComplaintPenghuniController::class, 'index'])->name('penghuni.complaint');
        Route::get('complaint/create', [ComplaintPenghuniController::class, 'create'])->name('penghuni.complaint.create');
        Route::post('complaint', [ComplaintPenghuniController::class, 'store'])->name('penghuni.complaint.store');
        Route::get('complaint/detail/{id}', [ComplaintPenghuniController::class, 'show'])->name('penghuni.complaint.show');
    });
});
