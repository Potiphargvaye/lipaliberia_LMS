<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_completions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('learning_material_id')
                ->constrained('learning_materials')
                ->cascadeOnDelete();

            $table->timestamp('completed_at');

            $table->timestamps();

            $table->unique(['student_id', 'learning_material_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_completions');
    }
};
