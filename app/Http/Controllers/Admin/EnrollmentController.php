<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    /**
     * Enrollment Management queue — one row per Enrollment.
     * All tab/status/action logic lives in
     * App\Livewire\Admin\Enrollments\Index; this method's only job is
     * authorizing the route and rendering the wrapper view.
     */
    public function index(): View
    {
        $this->authorize('manage enrollments');

        return view('admin.enrollments.index');
    }
}
