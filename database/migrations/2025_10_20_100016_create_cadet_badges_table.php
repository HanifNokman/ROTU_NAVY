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
        Schema::create('cadet_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadet_id')->constrained()->onDelete('cascade');
            $table->foreignId('badge_id')->constrained()->onDelete('cascade');
            $table->timestamp('unlocked_at');
            $table->boolean('is_displayed')->default(false); // For display badges feature
            $table->timestamps();

            $table->unique(['cadet_id', 'badge_id']); // Prevent duplicate badges
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadet_badges');
    }
};
