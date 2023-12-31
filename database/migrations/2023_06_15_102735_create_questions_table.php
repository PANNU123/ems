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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->integer('chapter_id');
            $table->integer('question_type_id');
            $table->integer('difficulty_level');
            $table->integer('marks');
            $table->text('question_text');
            $table->integer('academic_id')->nullable();
            $table->text('question_hint')->nullable();
            $table->text('question_detail')->nullable();
            $table->text('question_solution')->nullable();
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
