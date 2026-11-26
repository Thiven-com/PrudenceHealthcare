<?php

use App\Http\Controllers\Hospital\DepartmentController;
use App\Http\Controllers\Hospital\DesignationController;
use App\Http\Controllers\Hospital\HospitalAdditionalDetailsController;
use App\Http\Controllers\Hospital\HospitalDailyReportController;
use App\Http\Controllers\Hospital\LeadController;
use App\Http\Controllers\Hospital\PerformanceTargetController;
use App\Http\Controllers\Hospital\StaffController;
use App\Http\Controllers\Hospital\StaffDailyReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hospital\Auth\HospitalAuthController;
use App\Http\Controllers\Hospital\DashboardController;

Route::prefix('hospital')->name('hospital.')->group(function () {

    // Route::middleware('guest:hospital')->group(function () {

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
    // });

    // Authenticated Hospital Routes
    Route::middleware('hospital.auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('departments', DepartmentController::class);
        Route::resource('designations', DesignationController::class);
        Route::resource('staff', StaffController::class);
        Route::resource('leads', LeadController::class);

        Route::get(
            '/staff-daily-reports',
            [StaffDailyReportController::class, 'index']
        )->name('staff-daily-reports.index');

        Route::get(
            '/staff-daily-reports/{id}',
            [StaffDailyReportController::class, 'show']
        )->name('staff-daily-reports.show');

        Route::prefix('additional-details')
            ->name('additional-details.')
            ->controller(HospitalAdditionalDetailsController::class)
            ->group(function () {

                Route::get('/', 'index')->name('index');

                Route::post('/{type}', 'store')->name('store');

                Route::get('/{type}/{id}/edit', 'edit')->name('edit');

                Route::put('/{type}/{id}', 'update')->name('update');

                Route::delete('/{type}/{id}', 'destroy')->name('destroy');
            });

        Route::prefix('performance-targets')
            ->name('performance-targets.')
            ->controller(PerformanceTargetController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'store')->name('store');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
            });
        Route::post('/logout', [HospitalAuthController::class, 'logout'])
            ->name('logout');
    });
});