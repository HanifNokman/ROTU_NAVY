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
        Schema::create('performance_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadet_id')->constrained()->onDelete('cascade');
            $table->decimal('attendance_points', 5, 2)->default(0);
            $table->decimal('quiz_points', 5, 2)->default(0);
            $table->decimal('learning_progress_points', 5, 2)->default(0);
            $table->decimal('duty_points', 5, 2)->default(0);
            $table->decimal('academic_points', 5, 2)->default(0);
            $table->decimal('total_points', 5, 2)->default(0);
            $table->enum('rating', ['⭐☆☆☆☆', '⭐⭐☆☆☆', '⭐⭐⭐☆☆', '⭐⭐⭐⭐☆', '⭐⭐⭐⭐⭐'])->default('⭐☆☆☆☆');
            $table->timestamps();

            // Ensure one record per cadet
            $table->unique('cadet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_ratings');
    }
};
