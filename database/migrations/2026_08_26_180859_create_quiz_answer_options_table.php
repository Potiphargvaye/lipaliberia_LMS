<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pivot recording which option(s) a student selected for a given
        // answer — supports single-select (mcq/true_false) and
        // multi-select (checkbox) uniformly.
        Schema::create('quiz_answer_options', function (Blueprint $table) {
            $table->id();

            $table->foreignId('quiz_answer_id')
                ->constrained('quiz_answers')
                ->cascadeOnDelete();

            $table->foreignId('quiz_option_id')
                ->constrained('quiz_options')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['quiz_answer_id', 'quiz_option_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_answer_options');
    }
};
