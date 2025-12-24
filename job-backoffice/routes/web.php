<?php

use App\Http\Controllers\applicationController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\UserController;
use App\Models\job_application;
use App\Notifications\NewJobApplicationNotification;
use Illuminate\Support\Facades\Route;

// Middleware: admin + company-owner
Route::middleware(['auth', 'role:admin,company-owner'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Mark notification as read
    
    // Job Applications
    Route::resource('job-applications', applicationController::class);
    Route::put('/job-applications/{id}/restore', [applicationController::class, 'restore'])->name('job-applications.restore');

    // Job Vacancies
    Route::resource('job-vacancies', JobVacancyController::class);
    Route::put('/job-vacancies/{id}/restore', [JobVacancyController::class, 'restore'])->name('job-vacancies.restore');

    Route::post('/api/job-applications/notify', function (Request $request) {

    $application = job_application::findOrFail($request->applicationID);
    $job = $application->jobVacancy;

    $owner = $job->company->owner;

    $owner->notify(
        new NewJobApplicationNotification($job, $application)
    );

    return response()->json(['status' => 'ok']);
});

});

// Middleware: company-owner only
Route::middleware(['auth', 'role:company-owner'])->group(function () {
    Route::get('/my-company', [CompanyController::class, 'show'])->name('my-company.show');
    Route::get('/my-company/edit', [CompanyController::class, 'edit'])->name('my-company.edit');
    Route::put('/my-company', [CompanyController::class, 'update'])->name('my-company.update');
});

// Middleware: admin only
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::put('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');

    Route::resource('companies', CompanyController::class);
    Route::put('/companies/{id}/restore', [CompanyController::class, 'restore'])->name('companies.restore');

    Route::resource('job-categories', categoryController::class);
    Route::put('/job-categories/{id}/restore', [categoryController::class, 'restore'])->name('job-categories.restore');
});

require __DIR__ . '/auth.php';
