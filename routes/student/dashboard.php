<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Students\StudentDashboardController;


Route::middleware(['auth'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        Route::get('/dashboard', [StudentDashboardController::class, 'index'])
            ->name('dashboard');
    });
