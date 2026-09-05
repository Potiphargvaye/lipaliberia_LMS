


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Students\StudentDashboardController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GradeAssignmentController;
use App\Http\Controllers\TeacherMaterialController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\StudentGradeController;
use App\Http\Controllers\ReportCardController;
use App\Http\Controllers\Admin\FeeController;




// Landing page route
Route::get('/', function () {
    return view('auth.login');
})->name('auth.login');



// Public pages
require __DIR__ . '/public-page.php';



// Admin route files
require __DIR__ . '/admin/roles.php';
require __DIR__ . '/admin/permissions.php';
require __DIR__ . '/admin/role-permissions.php';
require __DIR__ . '/admin/users.php';
require __DIR__ . '/admin/dashboard.php';
require __DIR__ . '/admin/students.php';
require __DIR__ . '/admin/admissions.php';
require __DIR__ . '/admin/enrollments.php';
require __DIR__ . '/admin/fees.php';
require __DIR__ . '/admin/courses.php';
require __DIR__ . '/student/dashboard.php';
require __DIR__ . '/student/live-classes.php';
require __DIR__ . '/admin/course-categories.php';
require __DIR__ . '/admin/modules.php';
require __DIR__ . '/admin/learning-materials.php';
require __DIR__ . '/admin/quizzes.php';
require __DIR__ . '/admin/assignments.php';
require __DIR__ . '/admin/live-classes.php';




// Public student registration
require __DIR__ . '/student/register.php';



// Authentication routes
// Login, logout, password reset, register
require __DIR__ . '/auth.php';






// Authenticated routes
Route::middleware('auth')->group(function () {



    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');


    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');




    // Student dashboard
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
        ->middleware('role:student')
        ->name('student.dashboard');




    // Dashboard redirect
    Route::get('/dashboard', function () {


        $user = auth()->user();


        if ($user->hasRole('Student')) {
            return redirect()->route('student.dashboard');
        }


        return redirect()->route('admin.dashboard');
    })->name('dashboard');






    // Announcements Management

    Route::prefix('admin')
        ->middleware(['auth', 'role:admin'])
        ->group(function () {



            Route::prefix('announcements')->group(function () {



                Route::get('/', [
                    \App\Http\Controllers\Admin\AnnouncementController::class,
                    'index'
                ])->name('admin.announcements.index');



                Route::get('/create', [
                    \App\Http\Controllers\Admin\AnnouncementController::class,
                    'create'
                ])->name('admin.announcements.create');



                Route::post('/', [
                    \App\Http\Controllers\Admin\AnnouncementController::class,
                    'store'
                ])->name('admin.announcements.store');



                Route::get('/{announcement}/edit', [
                    \App\Http\Controllers\Admin\AnnouncementController::class,
                    'edit'
                ])->name('admin.announcements.edit');



                Route::put('/{announcement}', [
                    \App\Http\Controllers\Admin\AnnouncementController::class,
                    'update'
                ])->name('admin.announcements.update');



                Route::delete('/{announcement}', [
                    \App\Http\Controllers\Admin\AnnouncementController::class,
                    'destroy'
                ])->name('admin.announcements.destroy');
            });
        });






    // Student information and materials

    Route::prefix('student')
        ->name('student.')
        ->group(function () {



            Route::get('/dashboard', [StudentDashboardController::class, 'index'])
                ->name('dashboard');



            Route::get('/materials', [StudentDashboardController::class, 'materials'])
                ->name('materials');
        });
});
