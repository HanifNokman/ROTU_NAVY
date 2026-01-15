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
        Schema::table('applications', function (Blueprint $table) {
            $table->text('attendance_reason')->nullable()->after('attendance');
            $table->text('drill_test_reason')->nullable()->after('drill_test');
            $table->text('physical_test_reason')->nullable()->after('physical_test');
            $table->text('medical_test_reason')->nullable()->after('medical_test');
            $table->text('interview_reason')->nullable()->after('interview');
            $table->text('final_evaluation_reason')->nullable()->after('final_evaluation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'attendance_reason',
                'drill_test_reason',
                'physical_test_reason',
                'medical_test_reason',
                'interview_reason',
                'final_evaluation_reason',
            ]);
        });
    }
};
