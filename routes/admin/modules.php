<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ModuleController;

Route::middleware(['auth', 'can:manage modules'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/modules', [ModuleController::class, 'index'])
            ->name('modules.index');
    });
