<?php

namespace App\Services;

use App\Models\User;

class RegistrationIdService
{
    /**
     * Generate the next unique Student Registration ID.
     *
     * Format: LIPA/STU/{year}/{4-digit sequence} — e.g. LIPA/STU/2026/0001
     *
     * IMPORTANT: This is extracted verbatim from the original logic in
     * RegisteredUserController@store. The algorithm and format are
     * unchanged — only the location has moved, so both Public Registration
     * and Admin Registration call this single source of truth instead of
     * duplicating the loop. 
     */
    public function generate(): string
    {
        $year = now()->year;

        $lastStudent = User::role('Student')
            ->orderByDesc('id')
            ->first();

        $nextNumber = 1;

        if (
            $lastStudent &&
            preg_match('/(\d+)$/', $lastStudent->registration_id, $matches)
        ) {
            $nextNumber = (int) $matches[1] + 1;
        }

        do {
            $registrationId =
                'LIPA/STU/' .
                $year .
                '/' .
                str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $nextNumber++;
        } while (
            User::where('registration_id', $registrationId)->exists()
        );

        return $registrationId;
    }
}
