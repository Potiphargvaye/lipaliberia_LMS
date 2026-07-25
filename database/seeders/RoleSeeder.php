<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [

            'Super Admin',
            'Administrator',
            'Teacher',
            'Facilitator',
            'HR',
            'Finance',
            'Registrar',
            'Student',

        ];  

        foreach ($roles as $role) {

            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);

        }
    }
}