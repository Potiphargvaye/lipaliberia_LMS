<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
        public function run(): void
        {
                $permissions = [

                        /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

                        'view dashboard',

                        /*
            |--------------------------------------------------------------------------
            | Users
            |--------------------------------------------------------------------------
            */

                        'view users',
                        'create users',
                        'edit users',
                        'delete users',
                        'manage users',

                        /*
            |--------------------------------------------------------------------------
            | Roles
            |--------------------------------------------------------------------------
            */

                        'view roles',
                        'create roles',
                        'edit roles',
                        'delete roles',
                        'manage roles',

                        /*
            |--------------------------------------------------------------------------
            | Permissions
            |--------------------------------------------------------------------------
            */

                        'view permissions',
                        'create permissions',
                        'edit permissions',
                        'delete permissions',
                        'manage permissions',

                        /*
            |--------------------------------------------------------------------------
            | Students
            |--------------------------------------------------------------------------
            */

                        'view students',
                        'create students',
                        'edit students',
                        'delete students',
                        'view own student profile',

                        /*
            |--------------------------------------------------------------------------
            | Applications
            |--------------------------------------------------------------------------
            */

                        'review applications',
                        'approve applications',

                        /*
            |--------------------------------------------------------------------------
            | Enrollments
            |--------------------------------------------------------------------------
            */

                        'view enrollments',
                        'approve enrollments',
                        'reject enrollments',
                        'manage enrollments',

                        /*
            |--------------------------------------------------------------------------
            | Grades
            |--------------------------------------------------------------------------
            */

                        'view grades',
                        'create grades',
                        'edit grades',
                        'delete grades',
                        'manage grades',
                        'assign grade teachers',

                        /*
            |--------------------------------------------------------------------------
            | Grade Assignments
            |--------------------------------------------------------------------------
            */

                        'manage grade assignments',

                        /*
            |--------------------------------------------------------------------------
            | Student Grades
            |--------------------------------------------------------------------------
            */

                        'view student grades',
                        'create student grades',
                        'edit student grades',
                        'delete student grades',

                        /*
            |--------------------------------------------------------------------------
            | Subjects
            |--------------------------------------------------------------------------
            */

                        'view academic subjects',
                        'create academic subjects',
                        'edit academic subjects',
                        'delete academic subjects',
                        'manage academic subjects',

                        /*
            |--------------------------------------------------------------------------
            | Courses
            |--------------------------------------------------------------------------
            */

                        'view courses',
                        'create courses',
                        'edit courses',
                        'delete courses',

                        /*
            |--------------------------------------------------------------------------
            | Categories
            |--------------------------------------------------------------------------
            */

                        'manage categories',

                        /*
            |--------------------------------------------------------------------------
            | Lessons
            |--------------------------------------------------------------------------
            */

                        'view lessons',
                        'create lessons',
                        'edit lessons',
                        'delete lessons',

                        /*
            |--------------------------------------------------------------------------
            | Assignments
            |--------------------------------------------------------------------------
            */

                        'view assignments',
                        'create assignments',
                        'edit assignments',
                        'delete assignments',
                        'grade assignments',

                        /*
            |--------------------------------------------------------------------------
            | Quizzes
            |--------------------------------------------------------------------------
            */

                        'view quizzes',
                        'create quizzes',
                        'edit quizzes',
                        'delete quizzes',
                        'manage quizzes',

                        /*
            |--------------------------------------------------------------------------
            | Certificates
            |--------------------------------------------------------------------------
            */

                        'view certificates',
                        'issue certificates',

                        /*
            |--------------------------------------------------------------------------
            | Announcements
            |--------------------------------------------------------------------------
            */

                        'view announcements',
                        'create announcements',
                        'edit announcements',
                        'delete announcements',
                        'manage announcements',

                        /*
            |--------------------------------------------------------------------------
            | Fees
            |--------------------------------------------------------------------------
            */

                        'view fees',
                        'view fee details',
                        'create fees',
                        'edit fees',
                        'delete fees',
                        'manage fees',

                        /*
            |--------------------------------------------------------------------------
            | Reports
            |--------------------------------------------------------------------------
            */

                        'view reports',
                        'manage reports',

                        /*
            |--------------------------------------------------------------------------
            | Academic Years
            |--------------------------------------------------------------------------
            */

                        'view academic years',
                        'create academic years',
                        'edit academic years',
                        'delete academic years',
                        'manage academic years',

                        /*
            |--------------------------------------------------------------------------
            | Schools
            |--------------------------------------------------------------------------
            */

                        'view schools',
                        'create schools',
                        'edit schools',
                        'delete schools',
                        'manage schools',

                        /*
            |--------------------------------------------------------------------------
            | Admissions
            |--------------------------------------------------------------------------
            */

                        'view admissions',
                        'create admissions',
                        'edit admissions',
                        'delete admissions',
                        'manage admissions',

                        /*
            |--------------------------------------------------------------------------
            | Settings
            |--------------------------------------------------------------------------
            */

                        'manage settings',
                ];

                foreach ($permissions as $permission) {
                        Permission::firstOrCreate([
                                'name' => $permission,
                                'guard_name' => 'web',
                        ]);
                }
        }
}
