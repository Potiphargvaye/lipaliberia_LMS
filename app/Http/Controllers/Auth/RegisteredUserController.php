<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisteredUserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */


    /**
     * Show the registration form to the user.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration.app/Http/Controllers/Auth/RegisteredUserController.php
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'confirmed'
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048'
            ],

        ]);


        $imagePath = null;


        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('profile-images', 'public');
        }



        /*
|--------------------------------------------------------------------------
| Generate Student Registration ID
|--------------------------------------------------------------------------
*/

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

        /*
|--------------------------------------------------------------------------
| Ensure Registration ID is Always Unique
|--------------------------------------------------------------------------
*/

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


        $user = User::create([

            'registration_id' => $registrationId,

            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make(
                $request->password
            ),

            'image' => $imagePath,

            'status' => 'active',
            'created_by' => null,

        ]);



        /*
    |--------------------------------------------------------------------------
    | Default public registration role
    |--------------------------------------------------------------------------
    */

        $user->assignRole('Student');



        event(new Registered($user));


        return redirect()
            ->route('student.dashboard')
            ->with(
                'success',
                'Registration successful. Your LIPA ID is ' . $registrationId
            );
    }
}
