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
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon_path')->nullable(); // Icon class or path
            $table->text('description');
            $table->text('unlock_criteria');
            $table->string('category'); // attendance, quiz, learning, duty, academic, overall
            $table->integer('rarity_level')->default(1); // 1-5, 5 being rarest
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
