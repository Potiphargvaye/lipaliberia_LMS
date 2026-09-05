<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Assignment;
use App\Models\Course;

class AssignmentController extends Controller
{
    public function index(): View
    {
        return view('admin.assignments.index');
    }


    public function submissions(Assignment $assignment): View
    {
        $assignment->loadMissing('module.course');

        abort_unless(
            Course::visibleTo(auth()->user())->where('id', $assignment->module->course_id)->exists(),
            403
        );

        return view('admin.assignments.submissions', ['assignment' => $assignment]);
    }
}
