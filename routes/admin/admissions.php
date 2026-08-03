<?php

use App\Http\Controllers\Admin\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('admin/admissions')
    ->name('admin.admissions.')
    ->group(function () {

        Route::get('/', [ApplicationController::class, 'index'])
            ->middleware('permission:review applications')
            ->name('index');
    });
