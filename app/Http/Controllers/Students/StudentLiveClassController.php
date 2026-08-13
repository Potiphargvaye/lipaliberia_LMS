<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class StudentLiveClassController extends Controller
{
    public function index(): View
    {
        return view('student.live-classes.index');
    }
}
