<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HospitalAdditionalDetailsController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\HospitalDocumentController;
use App\Http\Controllers\Admin\LeadModuleController;
use App\Http\Controllers\Admin\LeadOverviewController;
use App\Http\Controllers\Admin\LeadReportController;
use App\Http\Controllers\Admin\PerformanceTargetController;
use App\Http\Controllers\Admin\StaffDailyReportController;
use App\Http\Controllers\Admin\StaffOverviewController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->group(function () {

    // Route::middleware('guest:admin')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('login.submit');

    // });

    Route::middleware('admin.auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/staff-overview/{id}', [StaffOverviewController::class, 'show'])
            ->name('staff-overview.show');

        Route::get(
            '/staff-daily-reports',
            [StaffDailyReportController::class, 'index']
        )->name('staff-daily-reports.index');

        Route::get(
            '/staff-daily-reports/{id}',
            [StaffDailyReportController::class, 'show']
        )->name('staff-daily-reports.show');

        Route::resource('hospitals', HospitalController::class);
        Route::prefix('hospitals')->name('hospitals.')->group(function () {
            Route::post('/{hospital}/approve', [HospitalController::class, 'approve'])
                ->name('approve');

            Route::post('/{hospital}/reject', [HospitalController::class, 'reject'])
                ->name('reject');

            Route::post('/{hospital}/suspend', [HospitalController::class, 'suspend'])
                ->name('suspend');

            Route::post('/{hospital}/reactivate', [HospitalController::class, 'reactivate'])
                ->name('reactivate');
        });
        Route::prefix('hospitals/{hospital}/documents')
            ->name('hospitals.documents.')
            ->group(function () {

                Route::get('/', [HospitalDocumentController::class, 'index'])
                    ->name('index');

                Route::post('/', [HospitalDocumentController::class, 'store'])
                    ->name('store');

                Route::post('/{document}/verify', [HospitalDocumentController::class, 'verify'])
                    ->name('verify');

                Route::post('/{document}/reject', [HospitalDocumentController::class, 'reject'])
                    ->name('reject');

                Route::delete('/{document}', [HospitalDocumentController::class, 'destroy'])
                    ->name('destroy');
            });

        Route::resource('lead-modules', LeadModuleController::class);
        Route::get('/staff-overview', [StaffOverviewController::class, 'index'])
            ->name('staff-overview.index');
        Route::get('/lead-overview', [LeadOverviewController::class, 'index'])
            ->name('lead-overview.index');

        Route::get('/lead-overview/{id}', [LeadOverviewController::class, 'show'])
            ->name('lead-overview.show');
        Route::get('/lead-overview/{module_id}', [LeadOverviewController::class, 'leadshow'])
            ->name('lead-overview.module-leads');
        Route::get('/lead-overview/lead/{id}', [LeadOverviewController::class, 'show'])
            ->name('lead-overview.lead.show');
        Route::get('/lead-reports', [LeadReportController::class, 'index'])
            ->name('lead-reports.index');

        Route::prefix('hospital/{hospital}')
            ->name('hospitals.')
            ->controller(HospitalAdditionalDetailsController::class)
            ->group(function () {
                Route::get('/facilities', 'facilities')->name('facilities');
                Route::get('/tieups', 'tieups')->name('tieups');
                Route::get('/emergency', 'emergency')->name('emergency');
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

        Route::post('/logout', [AdminAuthController::class, 'logout'])
            ->name('logout');

    });

});
