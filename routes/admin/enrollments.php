<?php

use App\Http\Controllers\Admin\EnrollmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('admin/enrollments')
    ->name('admin.enrollments.')
    ->group(function () {

        Route::get('/', [EnrollmentController::class, 'index'])
            ->middleware('permission:manage enrollments')
            ->name('index');
    });
