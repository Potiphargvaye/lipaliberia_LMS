<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cohort;

class CohortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cohorts = [
            [
                'name' => 'Cohort-1 2025',
                'code' => 'C1-2025',
                'start_date' => '2025-01-06',
                'end_date' => '2025-12-19',
                'application_deadline' => '2024-12-20',
                'sort_order' => 1,
                'is_active' => false,
            ],
            [
                'name' => 'Cohort-2 2026',
                'code' => 'C2-2026',
                'start_date' => '2026-01-05',
                'end_date' => '2026-12-18',
                'application_deadline' => '2025-12-20',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Cohort-3 2027',
                'code' => 'C3-2027',
                'start_date' => '2027-01-04',
                'end_date' => '2027-12-17',
                'application_deadline' => '2026-12-20',
                'sort_order' => 3,
                'is_active' => false,
            ],
            [
                'name' => 'Cohort-4 2028',
                'code' => 'C4-2028',
                'start_date' => '2028-01-03',
                'end_date' => '2028-12-15',
                'application_deadline' => '2027-12-20',
                'sort_order' => 4,
                'is_active' => false,
            ],
        ];

        foreach ($cohorts as $cohort) {
            Cohort::updateOrCreate(
                ['code' => $cohort['code']],
                $cohort
            );
        }
    }
}
