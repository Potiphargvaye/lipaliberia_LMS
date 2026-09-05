<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_materials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('module_id')
                ->constrained('modules')
                ->cascadeOnDelete();

            $table->string('title');
            $table->string('type');

            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->longText('content')->nullable();
            $table->text('description')->nullable();

            $table->unsignedInteger('material_order');

            $table->boolean('is_active')->default(true);

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // material_order must be unique per module, not globally
            $table->unique(['module_id', 'material_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_materials');
    }
};
