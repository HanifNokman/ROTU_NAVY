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
        Schema::create('training_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained()->onDelete('cascade');
            $table->foreignId('cadet_id')->constrained()->onDelete('cascade');
            $table->boolean('present')->default(false);
            // FIXED: Changed from enum to string and added 'geofence' option
            $table->string('method', 50)->default('manual')->comment('manual, qr_code, geofence');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamp('marked_at')->nullable();
            $table->text('absence_reason')->nullable();
            $table->string('file_url')->nullable();
            $table->timestamps();
            
            // Ensure one record per training per cadet
            $table->unique(['training_id', 'cadet_id']);
            
            // Indexes for better query performance
            $table->index('training_id');
            $table->index('cadet_id');
            $table->index(['present', 'training_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_attendances');
    }
};