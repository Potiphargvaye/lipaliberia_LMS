<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // Nullable + added after existing columns so nothing about the
            // current `category` text column or existing rows is touched.
            $table->foreignId('course_category_id')
                ->nullable()
                ->after('category')
                ->constrained('course_categories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('course_category_id');
        });
    }
};
