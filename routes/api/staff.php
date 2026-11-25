<?php

use App\Http\Controllers\StaffApp\HospitalDetailsController;
use App\Http\Controllers\StaffApp\PerformanceController;
use App\Http\Controllers\StaffApp\StaffAuthController;
use App\Http\Controllers\StaffApp\StaffController;
use App\Http\Controllers\StaffApp\StaffDailyReportController;
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
        Route::get('/hospital-details', [HospitalDetailsController::class, 'index']);

        Route::get('/members', [StaffController::class, 'index']);
        Route::get('/marketing-designations', [StaffController::class, 'designations']);
        Route::post('/add-member', [StaffController::class, 'store']);
        Route::get('/members/{id}', [StaffController::class, 'show']);

        // My daily reports
        Route::get('/daily-reports', [StaffDailyReportController::class, 'index']);
        Route::get('/daily-reports/today', [StaffDailyReportController::class, 'today']);
        Route::post('/daily-reports', [StaffDailyReportController::class, 'store']);
        Route::get('/daily-reports/{id}', [StaffDailyReportController::class, 'show']);
        Route::put('/daily-reports/{id}', [StaffDailyReportController::class, 'update']);

        // Daily activities
        Route::post('/daily-reports/{reportId}/activities', [StaffDailyReportController::class, 'storeActivity']);
        Route::put('/daily-reports/{reportId}/activities/{activityId}', [StaffDailyReportController::class, 'updateActivity']);
        Route::delete('/daily-reports/{reportId}/activities/{activityId}', [StaffDailyReportController::class, 'destroyActivity']);

        // Submit report
        Route::post('/daily-reports/{id}/submit', [StaffDailyReportController::class, 'submit']);

        // Reports from staff members added by me
        Route::get('/team-daily-reports', [StaffDailyReportController::class, 'teamReports']);
        Route::get('/team-daily-reports/{id}', [StaffDailyReportController::class, 'teamReportShow']);
        Route::post('/team-daily-reports/{id}/review', [StaffDailyReportController::class, 'managerReview']);
        Route::get('/my-performance', [PerformanceController::class, 'index'])
            ->name('my-performance');
        Route::post('/logout', [StaffAuthController::class, 'logout'])
            ->name('logout');

    });
});