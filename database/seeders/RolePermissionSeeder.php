<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::findByName('Super Admin');

        $superAdmin->syncPermissions(
            Permission::pluck('name')->toArray()
        );

        /*
        |--------------------------------------------------------------------------
        | Administrator  
        |--------------------------------------------------------------------------
        */

        $admin = Role::findByName('Administrator');

        $admin->syncPermissions([

            'view dashboard',

            'view users',
            'create users',
            'edit users',
            'delete users',

            'view students',
            'create students',
            'edit students',
            'delete students',

            'view courses',
            'create courses',
            'edit courses',
            'delete courses',

            'manage categories',

            'view lessons',
            'create lessons',
            'edit lessons',
            'delete lessons',

            'view enrollments',
            'approve enrollments',
            'reject enrollments',

            'create assignments',
            'grade assignments',

            'create quizzes',
            'manage quizzes',

            'manage announcements',

            'issue certificates',

            'view reports',

            'manage settings',
            'view roles',
'create roles',
'edit roles',
'delete roles',

'view permissions',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Teacher
        |--------------------------------------------------------------------------
        */

        $teacher = Role::findByName('Teacher');

        $teacher->syncPermissions([

            'view dashboard',

            'view students',

            'view courses',

            'view lessons',
            'create lessons',
            'edit lessons',

            'view enrollments',

            'create assignments',
            'grade assignments',

            'create quizzes',

            'manage announcements',

            'view reports',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Facilitator
        |--------------------------------------------------------------------------
        */

        $facilitator = Role::findByName('Facilitator');

        $facilitator->syncPermissions([

'view dashboard',

'view students',

'view courses',

'view lessons',

'create assignments',

'create quizzes',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Student
        |--------------------------------------------------------------------------
        */

        Role::findByName('Student')->syncPermissions([]);

        /*
        |--------------------------------------------------------------------------
        | HR
        |--------------------------------------------------------------------------
        */

       Role::findByName('HR')->syncPermissions([
    'view dashboard',

    'view users',
    'create users',
    'edit users',

    'view reports',
]);

        /*
        |--------------------------------------------------------------------------
        | Finance
        |--------------------------------------------------------------------------
        */

       Role::findByName('Finance')->syncPermissions([
    'view dashboard',

    'view reports',
]);

        /*
        |--------------------------------------------------------------------------
        | Registrar
        |--------------------------------------------------------------------------
        */

      Role::findByName('Registrar')->syncPermissions([

    'view dashboard',

    'view students',
    'create students',
    'edit students',

    'view enrollments',
    'approve enrollments',
]);
    }
}