<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AssignmentController;

Route::middleware(['auth', 'can:manage assignments'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/assignments', [AssignmentController::class, 'index'])
            ->name('assignments.index');

        Route::get('/assignments/{assignment}/submissions', [AssignmentController::class, 'submissions'])
            ->name('assignments.submissions');
    });
