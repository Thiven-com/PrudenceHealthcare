<?php

use App\Http\Controllers\StaffApp\StaffAuthController;
use App\Http\Controllers\StaffApp\StaffDashboardController;
use App\Http\Controllers\StaffApp\StaffFollowUpController;
use App\Http\Controllers\StaffApp\StaffLeadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

Route::name('api.staff.')->group(function () {

    // Public authentication APIs
    Route::post('/login', [StaffAuthController::class, 'sendOtp'])
        ->name('send-otp');

    Route::post('/verify-otp', [StaffAuthController::class, 'verifyOtp'])
        ->name('verify-otp');

    // Authenticated APIs
    Route::middleware('staffapp.auth')->group(function () {

        Route::get('/profile', [StaffAuthController::class, 'profile'])
            ->name('profile');
        Route::get('/dashboard', [StaffDashboardController::class, 'index']);

        Route::get('/leads', [StaffLeadController::class, 'index']);
        Route::get('/leads/{id}', [StaffLeadController::class, 'show']);
        Route::get('/lead-options', [StaffLeadController::class, 'createLeadOptions']);
        Route::post('/leads', [StaffLeadController::class, 'store']);
        Route::put('/leads/{id}', [StaffLeadController::class, 'update']);
        Route::get('/lead-assignment-options', [StaffLeadController::class, 'assignmentOptions']);
        Route::post('/leads/{id}/assign', [StaffLeadController::class, 'assignLead']);
        Route::put('/leads/{id}/status', [StaffLeadController::class, 'updateStatus']);

        Route::get('/followups', [StaffFollowUpController::class, 'index']);
        Route::post('/followups', [StaffFollowUpController::class, 'store']);
        Route::put('/followups/{id}', [StaffFollowUpController::class, 'update']);
        Route::delete('/followups/{id}', [StaffFollowUpController::class, 'destroy']);
        Route::post('/logout', [StaffAuthController::class, 'logout'])
            ->name('logout');

    });
});