<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LiveClassController;

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/live-classes', [LiveClassController::class, 'index'])
            ->name('live-classes.index');
    });
