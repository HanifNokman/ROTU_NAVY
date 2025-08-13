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
            $table->enum('method', ['manual', 'qr_code'])->default('manual');
            $table->timestamp('marked_at')->nullable();
            $table->timestamps();
            
            // Ensure one record per training per cadet
            $table->unique(['training_id', 'cadet_id']);
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