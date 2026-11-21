<?php

use App\Http\Controllers\Hospital\DepartmentController;
use App\Http\Controllers\Hospital\DesignationController;
use App\Http\Controllers\Hospital\LeadController;
use App\Http\Controllers\Hospital\StaffController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hospital\Auth\HospitalAuthController;
use App\Http\Controllers\Hospital\DashboardController;

Route::prefix('hospital')->name('hospital.')->group(function () {

    Route::middleware('guest:hospital')->group(function () {

        // Login
        Route::get('/login', [HospitalAuthController::class, 'showLogin'])
            ->name('login');

        Route::post('/login', [HospitalAuthController::class, 'sendLoginOtp'])
            ->name('login.submit');

        Route::post('/verify-login-otp', [HospitalAuthController::class, 'verifyLoginOtp'])
            ->name('verify-login-otp');

        // Registration
        Route::get('/register', [HospitalAuthController::class, 'showRegister'])
            ->name('register');

        Route::post('/register', [HospitalAuthController::class, 'register'])
            ->name('register.submit');

        Route::get('/register/verify-otp', [HospitalAuthController::class, 'showRegistrationOtp'])
            ->name('register.verify');

        Route::post('/register/verify-otp', [HospitalAuthController::class, 'verifyRegistrationOtp'])
            ->name('register.verify.submit');
    });

    // Authenticated Hospital Routes
    Route::middleware('hospital.auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('departments', DepartmentController::class);
        Route::resource('designations', DesignationController::class);
        Route::resource('staff', StaffController::class);
        Route::resource('leads', LeadController::class);
        Route::post('/logout', [HospitalAuthController::class, 'logout'])
            ->name('logout');
    });
});