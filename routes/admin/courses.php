<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CourseController;

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/courses', [CourseController::class, 'index'])
            ->name('courses.index');
    });
