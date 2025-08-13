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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location');
            $table->datetime('start_datetime');
            $table->datetime('end_datetime')->nullable();
            $table->string('involvement')->nullable(); // Groups or cadets involved
            $table->integer('duration_hours')->nullable(); // Duration in hours (2-10)
            $table->decimal('allowance_amount', 8, 2)->nullable(); // Calculated allowance
            $table->enum('allowance_type', ['hourly', 'daily'])->nullable(); // Type of allowance calculation
            $table->enum('status', ['Active', 'Completed', 'Cancelled'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};