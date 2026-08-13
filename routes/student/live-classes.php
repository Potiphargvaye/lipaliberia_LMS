<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Students\StudentLiveClassController;

Route::middleware(['auth'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        Route::get('/live-classes', [StudentLiveClassController::class, 'index'])
            ->name('live-classes.index');
    });
