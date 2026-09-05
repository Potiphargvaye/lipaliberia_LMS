<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LearningMaterialController;

Route::middleware(['auth', 'can:manage learning materials'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/learning-materials', [LearningMaterialController::class, 'index'])
            ->name('learning-materials.index');
    });
