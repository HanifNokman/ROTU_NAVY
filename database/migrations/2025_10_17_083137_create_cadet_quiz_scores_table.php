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
        Schema::create('cadet_quiz_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadet_id')->constrained()->onDelete('cascade');
            $table->foreignId('learning_material_category_id')->nullable()->constrained('learning_material_categories')->onDelete('cascade'); // null for "all categories"
            $table->decimal('score_percentage', 5, 2)->default(0); // 0.00 to 100.00
            $table->enum('difficulty', ['easy', 'medium', 'hard']);
            $table->integer('total_questions');
            $table->integer('correct_answers');
            $table->timestamp('completed_at');
            $table->timestamps();

            // Index for performance
            $table->index(['cadet_id', 'difficulty', 'completed_at'], 'cadet_quiz_scores_performance_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadet_quiz_scores');
    }
};
