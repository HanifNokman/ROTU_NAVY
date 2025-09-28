<?php
// File: create_quiz_questions_table.php

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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('learning_material_categories')->onDelete('cascade');
            $table->text('question_text');
            $table->string('file_url')->nullable();
            $table->enum('question_type', ['MCQ', 'Subjective'])->default('MCQ'); // Add default
            $table->string('option_a')->nullable();
            $table->string('option_b')->nullable();
            $table->string('option_c')->nullable();
            $table->string('option_d')->nullable();
            $table->text('correct_answer');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            // Add indexes for performance
            $table->index(['category_id', 'status']);
            $table->index(['question_type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};