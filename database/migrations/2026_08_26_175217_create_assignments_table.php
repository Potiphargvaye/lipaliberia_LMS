<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('module_id')
                ->unique() // one assignment per module
                ->constrained('modules')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('instructions')->nullable();

            $table->string('content_type'); // text, file — how the admin posted the brief
            $table->longText('content_text')->nullable();
            $table->string('content_file_path')->nullable();

            $table->dateTime('due_date')->nullable();

            $table->boolean('is_required')->default(true);
            $table->boolean('is_active')->default(true);

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
