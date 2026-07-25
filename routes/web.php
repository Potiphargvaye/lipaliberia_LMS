<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Students\StudentDashboardController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GradeAssignmentController;
use App\Http\Controllers\TeacherMaterialController; // Correct import for the teacher controller 
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserPermissionController;
use App\Http\Controllers\StudentGradeController;
use App\Http\Controllers\Students\StudentPortalGradeController;
// routes for report card printing
use App\Http\Controllers\ReportCardController;


use App\Http\Controllers\Admin\FeeController; // Add this import



// Landing page route  
Route::get('/', function () {
    return view('auth.login');
})->name('auth.login');
// Landing page route (updated)
require __DIR__ . '/public-page.php'; // for my public page routes    

require __DIR__ . '/admin/roles.php';
require __DIR__ . '/admin/permissions.php';
require __DIR__ . '/admin/role-permissions.php';
require __DIR__ . '/admin/users.php';
require __DIR__ . '/admin/dashboard.php';



// Admin-only registration routes (added this new section)
// In routes/web.php this will redirect admin to the register page
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// Authenticated routes (keep exactly as is)
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Role-specific dashboards
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
        ->middleware('role:student')
        ->name('student.dashboard');


    Route::middleware('auth')->get('/dashboard', function () {

        $user = auth()->user();

        if ($user->hasRole('Student')) {
            return redirect()->route('student.dashboard');
        }

        return redirect()->route('admin.dashboard');
    })->name('dashboard');







    //  ROUTE BASE FOR THE PERMISSION AND ACCESS )
    Route::middleware(['auth', 'permission:manage users'])
        ->prefix('admin')->name('admin.')
        ->group(function () {
            Route::get('/users/{user}/permissions', [UserPermissionController::class, 'edit'])->name('users.permissions.edit');
            Route::post('/users/{user}/permissions', [UserPermissionController::class, 'update'])->name('users.permissions.update');
        });
});

// Modified auth routes (replace the require line with these exact routes)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


// Add this at the bottom of your current web.php, before the closing PHP tag if any

// Announcements Management
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('announcements')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AnnouncementController::class, 'index'])
            ->name('admin.announcements.index');

        Route::get('/create', [\App\Http\Controllers\Admin\AnnouncementController::class, 'create'])
            ->name('admin.announcements.create');

        Route::post('/', [\App\Http\Controllers\Admin\AnnouncementController::class, 'store'])
            ->name('admin.announcements.store');

        Route::get('/{announcement}/edit', [\App\Http\Controllers\Admin\AnnouncementController::class, 'edit'])
            ->name('admin.announcements.edit');

        Route::put('/{announcement}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'update'])
            ->name('admin.announcements.update');

        Route::delete('/{announcement}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'destroy'])
            ->name('admin.announcements.destroy');
    });
});



Route::prefix('teacher')->middleware(['auth', 'role:teacher'])->group(function () {
    // This will create routes with names like: teacher.materials.store
    Route::resource('materials', TeacherMaterialController::class)
        ->names('teacher.materials');

    Route::post('materials/{material}/toggle-publish', [TeacherMaterialController::class, 'togglePublish'])
        ->name('teacher.materials.toggle-publish');

    // Remove the duplicate '/teacher/' from the path
    Route::get('materials/create', [TeacherMaterialController::class, 'create'])->name('teacher.materials.create');
});



// routes/web.php 


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Student Management Routes
    // ✅ Students page — route-level permission protection
    Route::get('/students', [StudentController::class, 'index'])
        ->name('students.index')
        ->middleware('permission:view students'); // <- safe permission check
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');

    Route::get('/students/{student}', [StudentController::class, 'show'])
        ->middleware('permission:view student details')
        ->name('students.show');

    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])
        ->middleware('permission:edit students')
        ->name('students.edit');

    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');

    Route::delete('/students/{student}', [StudentController::class, 'destroy'])
        ->middleware('permission:delete students')
        ->name('students.destroy');

    // Alternative: You can use resource route instead (generates all above routes)
    // Route::resource('students', StudentController::class);
});










// ======Rout for student information  displaying  and  students  materials 

Route::middleware(['auth'])->group(function () {
    // Student routes
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/materials', [StudentDashboardController::class, 'materials'])->name('materials');
        Route::get('/grades', [StudentPortalGradeController::class, 'index'])

            ->name('grades');
    });
});
