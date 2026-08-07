<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        $this->authorize('manage fees');

        return view('admin.courses.index');
    }
}
