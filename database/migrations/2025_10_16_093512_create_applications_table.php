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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('ic_number')->unique();
            $table->string('matric_no')->unique();
            $table->string('faculty');
            $table->string('course');
            $table->string('profile_pic')->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable(); 
            $table->decimal('bmi', 4, 2)->nullable(); 
            $table->enum('attendance', ['pending', 'passed', 'failed'])->default('pending');
            $table->enum('drill_test', ['pending', 'passed', 'failed'])->default('pending');
            $table->enum('physical_test', ['pending', 'passed', 'failed'])->default('pending');
            $table->enum('medical_test', ['pending', 'passed', 'failed'])->default('pending');
            $table->enum('interview', ['pending', 'passed', 'failed'])->default('pending');
            $table->enum('final_evaluation', ['pending', 'passed', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
