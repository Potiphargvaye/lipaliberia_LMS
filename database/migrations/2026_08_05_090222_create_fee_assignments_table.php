<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_assignments', function (Blueprint $table) {

            $table->id();

            // Links directly to the student's enrollment
            $table->foreignId('enrollment_id')
                ->constrained('enrollments')
                ->cascadeOnDelete();

            // Fee Type
            $table->foreignId('fee_category_id')
                ->constrained('fee_categories')
                ->restrictOnDelete();

            // Optional installment label
            $table->string('installment_number')->nullable();

            // Fee Details
            $table->decimal('amount', 10, 2);

            $table->date('due_date');

            $table->text('remarks')->nullable();

            // Current payment status
            $table->enum('status', [
                'pending',
                'partial',
                'paid',
                'overdue'
            ])->default('pending');

            // Administrator that assigned the fee
            $table->foreignId('assigned_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_assignments');
    }
};





