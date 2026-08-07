<?php

use App\Http\Controllers\Public\PublicStudentController;
use Illuminate\Support\Facades\Route;

// No auth middleware — these are public-facing routes.

Route::get('/register', [PublicStudentController::class, 'create'])
    ->name('public.students.create');

Route::post('/register', [PublicStudentController::class, 'store'])
    ->name('public.students.store');

Route::get('/verify/{id}', [PublicStudentController::class, 'verifyReportCard'])
    ->name('public.students.verify');
