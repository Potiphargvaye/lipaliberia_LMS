<?php

use App\Http\Controllers\Admin\CourseCategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'can:manage course categories'])->group(function () {
    Route::get('/course-categories', [CourseCategoryController::class, 'index'])
        ->name('admin.course-categories.index');
});
