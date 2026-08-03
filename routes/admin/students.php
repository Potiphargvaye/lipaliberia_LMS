<?php

use App\Http\Controllers\Admin\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('admin/students')
    ->name('admin.students.')
    ->group(function () {

        Route::get('/', [StudentController::class, 'index'])
            ->middleware('permission:view students')
            ->name('index');

        // Must be registered before the '/{student}' route below, otherwise
        // Laravel will try to resolve "create" as a Student route-model
        // binding and 404.
        Route::get('/create', [StudentController::class, 'create'])
            ->middleware('permission:create students')
            ->name('create');

        Route::get('/{student}', [StudentController::class, 'show'])
            ->middleware('permission:view students')
            ->name('show');
    });
