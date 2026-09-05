<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Course;
use App\Models\Quiz;


class QuizController extends Controller
{
    public function index(): View
    {
        return view('admin.quizzes.index');
    }


    public function results(Quiz $quiz): View
    {
        $quiz->loadMissing('module.course');

        // Route-level middleware only checks the *feature* permission
        // (manage quizzes). This checks the *course* is actually within
        // this user's scope — required so a facilitator can't view results
        // for another facilitator's quiz just by typing the URL.
        abort_unless(
            Course::visibleTo(auth()->user())->where('id', $quiz->module->course_id)->exists(),
            403
        );

        return view('admin.quizzes.results', ['quiz' => $quiz]);
    }
}
