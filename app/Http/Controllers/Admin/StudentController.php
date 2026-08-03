<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Student Management list — one row per Student.
     * All search/filter/table interactivity lives in the
     * App\Livewire\Admin\Students\Index component; this method's
     * only job is authorizing the route and rendering the wrapper view.
     */
    public function index(): View
    {
        $this->authorize('view students');

        return view('admin.students.index');
    }

    /**
     * Admin-side Student Registration — reachable from the
     * "+ Register Student" button on the Students Index.
     * All wizard/step/transaction logic lives in
     * App\Livewire\Admin\Students\Registration.
     */
    public function create(): View
    {
        $this->authorize('create students');

        return view('admin.students.create');
    }

    /**
     * A single Student's tabbed profile — Overview / Personal / Employment /
     * Education / Application History / Enrollment History / Documents.
     * All tab logic lives in App\Livewire\Admin\Students\Profile.
     */
    public function show(Student $student): View
    {
        $this->authorize('view students');

        return view('admin.students.profile', compact('student'));
    }
}
