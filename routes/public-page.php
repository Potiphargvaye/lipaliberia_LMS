<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\PublicStudentController;

use App\Http\Controllers\CourseController;

Route::get('/', function () {
    return view('public.index'); // <- note the dot notation for subfolders
})->name('home');

Route::get('/about-us', function () {
    return view('public.about-us');
});

Route::get('/fees-structure', function () {
    return view('public.fees-structure');
});

Route::get('/courses', function () {
    return view('public.courses');
});


Route::get('/team', function () {
    return view('public.team');
});


Route::get('/contact-us', function () {
    return view('public.contact-us');
});


Route::get('/blog', function () {
    return view('public.blog');
});


Route::get('/registeration-form', function () {
    return view('public.registeration-form');
});




// Verification engine endpoint linking directly to your controller method above
// Verification engine endpoint explicitly looking for standard database primary IDs
// Verification engine endpoint looking for structural student_ids with slash character safety rules
Route::get('/verify/report-card/{id}', [PublicStudentController::class, 'verifyReportCard'])
    ->name('public.verify.report_card')
    ->where('id', '.*');

Route::get('/student/register', [PublicStudentController::class, 'create'])
    ->name('public.students.create');

Route::post('/student/register', [PublicStudentController::class, 'store'])
    ->name('public.students.store');



/**
 * Add these two lines to routes/web.php (near your other public routes).
 * Requires: use App\Http\Controllers\CourseController;
 */


Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');

/**
 * IMPORTANT: register these BEFORE any catch-all/wildcard route you may
 * already have (e.g. a generic {page} route for CMS pages), otherwise the
 * wildcard route will intercept /courses/{slug} first and this will never
 * be reached.
 */
