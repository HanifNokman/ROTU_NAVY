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
        Schema::table('cadets', function (Blueprint $table) {
            $table->boolean('is_best_cadet')->default(false)->after('cadet_status');
            $table->boolean('is_best_academic')->default(false)->after('is_best_cadet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cadets', function (Blueprint $table) {
            $table->dropColumn(['is_best_cadet', 'is_best_academic']);
        });
    }
};
