<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Show the full course listing (Certificate / Flagship / Orientation),
     * grouped for display. This replaces the hardcoded HTML previously in
     * courses.blade.php — the view now just loops over this data.
     */
    public function index()
    {
        $courses = collect(config('courses'))
            ->map(function ($course, $slug) {
                return array_merge($course, ['slug' => $slug]);
            });

        // Preserve the three sections in a fixed, sensible order regardless
        // of how config/courses.php happens to be ordered internally.
        $groups = [
            'certificate' => $courses->where('group', 'certificate'),
            'flagship' => $courses->where('group', 'flagship'),
            'orientation' => $courses->where('group', 'orientation'),
        ];

        return view('public.courses', compact('groups'));
    }

    /**
     * Show a single course's details page.
     *
     * Route: GET /courses/{slug}  ->  route('courses.show', $slug)
     *
     * Because the slug is looked up directly against config/courses.php,
     * only the matching course's data is ever passed to the view — there is
     * no way for another course's details to leak onto this page.
     */
    public function show(string $slug)
    {
        $course = config("courses.$slug");

        abort_if(is_null($course), 404);

        $course['slug'] = $slug;

        // Small "related courses" list — same group, excluding the current course.
        $related = collect(config('courses'))
            ->map(fn($c, $s) => array_merge($c, ['slug' => $s]))
            ->where('group', $course['group'])
            ->where('slug', '!=', $slug)
            ->take(3);

        return view('public.course-details', compact('course', 'related'));
    }
}
