<?php

use App\Http\Controllers\Auth\RegisterController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');



Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');
