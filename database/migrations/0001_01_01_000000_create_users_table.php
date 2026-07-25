<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            /*
    |--------------------------------------------------------------------------
    | Login Information
    |--------------------------------------------------------------------------
    */

            $table->string('registration_id')->unique();

            $table->string('name');

            $table->string('email')->unique();

            $table->string('image')->nullable();

            /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');

            /*
    |--------------------------------------------------------------------------
    | Account Status
    |--------------------------------------------------------------------------
    */

            $table->enum('status', [
                'active',
                'inactive',
                'suspended'
            ])->default('active');

            /*
    |--------------------------------------------------------------------------
    | Login Tracking
    |--------------------------------------------------------------------------
    */

            $table->timestamp('last_login_at')->nullable();

            $table->rememberToken();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
