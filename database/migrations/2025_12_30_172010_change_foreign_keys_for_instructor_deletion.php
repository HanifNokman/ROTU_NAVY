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
        // Change galleries foreign key from cascade to set null
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['instructor_id']);
            $table->unsignedBigInteger('instructor_id')->nullable()->change();
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('set null');
        });

        // Change learning_materials foreign key from cascade to set null
        Schema::table('learning_materials', function (Blueprint $table) {
            $table->dropForeign(['instructor_id']);
            $table->unsignedBigInteger('instructor_id')->nullable()->change();
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert galleries foreign key back to cascade
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropForeign(['instructor_id']);
            $table->unsignedBigInteger('instructor_id')->nullable(false)->change();
            $table->foreign('instructor_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Revert learning_materials foreign key back to cascade
        Schema::table('learning_materials', function (Blueprint $table) {
            $table->dropForeign(['instructor_id']);
            $table->unsignedBigInteger('instructor_id')->nullable(false)->change();
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
        });
    }
};
