<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuizController;

Route::middleware(['auth', 'can:manage quizzes'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/quizzes', [QuizController::class, 'index'])
            ->name('quizzes.index');

        Route::get('/quizzes/{quiz}/results', [QuizController::class, 'results'])
            ->name('quizzes.results');
    });
