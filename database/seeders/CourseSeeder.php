<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $courses = config('courses');

        foreach ($courses as $slug => $course) {

            Course::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $course['title'],
                    'slug' => $slug,
                    'category' => $course['category'],
                    'group' => $course['group'],
                    'group_label' => $course['group_label'],
                    'programme_type' => $course['programme_type'],

                    'overview' => $course['overview'],
                    'target_audience' => $course['target_audience'],
                    'entry_requirements' => $course['entry_requirements'],

                    'duration' => $course['duration'],
                    'schedule' => $course['schedule'],
                    'fee' => str_replace('$', '', $course['fee']),
                    'seats' => $course['seats'],

                    'image' => $course['image'],

                    'is_active' => true,
                ]
            );
        }
    }
}
