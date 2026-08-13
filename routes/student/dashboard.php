<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Students\StudentDashboardController;
use App\Http\Controllers\Students\StudentFeesController;

Route::middleware(['auth'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        Route::get('/dashboard', [StudentDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/fees', [StudentFeesController::class, 'index'])
            ->name('fees.index');
    });
