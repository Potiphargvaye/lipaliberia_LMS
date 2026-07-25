<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('teacher_materials', function (Blueprint $table) {
           $table->id();
$table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
$table->string('title');
$table->text('description')->nullable();
$table->string('attachment')->nullable();
$table->boolean('status')->default(true);
$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_materials');
    }
};