<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('learning_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instructor_id');
            $table->string('title');
            $table->text('content')->nullable(); // optional description
            $table->string('file_url'); // can store S3/local URL
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
            $table->foreignId('learning_material_category_id')->constrained('learning_material_categories');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_materials');
    }
};
