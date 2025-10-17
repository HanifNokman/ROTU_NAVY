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
        // Track individual learning material completion
        Schema::create('cadet_learning_material_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadet_id')->constrained('cadets')->onDelete('cascade');
            $table->foreignId('learning_material_id')->constrained('learning_materials')->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->integer('time_spent_seconds')->default(0); // For tracking video/audio progress
            $table->timestamps();
            
            // Ensure one record per cadet per material
            $table->unique(['cadet_id', 'learning_material_id'], 'cadet_material_unique');
            
            // Add indexes for better query performance
            $table->index('cadet_id');
            $table->index('learning_material_id');
            $table->index('is_completed');
        });

        // Track category-level progress
        Schema::create('cadet_category_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadet_id')->constrained('cadets')->onDelete('cascade');
            $table->foreignId('learning_material_category_id')->constrained('learning_material_categories')->onDelete('cascade');
            $table->integer('completed_materials')->default(0);
            $table->integer('total_materials')->default(0);
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->timestamps();
            
            // Ensure one record per cadet per category
            $table->unique(['cadet_id', 'learning_material_category_id'], 'cadet_category_unique');
            
            // Add indexes for better query performance
            $table->index('cadet_id');
            $table->index('learning_material_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadet_category_progress');
        Schema::dropIfExists('cadet_learning_material_progress');
    }
};