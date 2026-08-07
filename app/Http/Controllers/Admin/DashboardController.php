<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the LIPA Admin Dashboard.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | User Statistics
        |--------------------------------------------------------------------------
        */

        // $totalUsers = User::count();

        // Staff users (everyone except students)
        // $totalStaff = User::whereDoesntHave('roles', function ($query) {
        //     $query->where('name', 'Student');
        // })->count();

        // Students
        // $totalStudents = Student::count();


        /*
        |--------------------------------------------------------------------------
        | Student Statistics
        |--------------------------------------------------------------------------
        */

        // $totalCandidates = Student::where('status', 'candidate')->count();

        // $totalAdmitted = Student::where('status', 'admitted')->count();

        // $totalRegistered = Student::where('status', 'registered')->count();

        // $totalActive = Student::where('status', 'active')->count();

        // $totalCompleted = Student::where('status', 'completed')->count();

        // $totalDropout = Student::where('status', 'dropout')->count();


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard');

        /*
        // Restore this later when the dashboard cards are needed.

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStaff',
            'totalStudents',
            'totalCandidates',
            'totalAdmitted',
            'totalRegistered',
            'totalActive',
            'totalCompleted',
            'totalDropout'
        ));
        */
    }
}
