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
        // Update existing records with PKOR to Officer
        \DB::table('instructors')
            ->where('expertise', 'PKOR')
            ->update(['expertise' => 'Officer']);

        // Modify the enum to replace PKOR with Officer
        \DB::statement("ALTER TABLE instructors MODIFY COLUMN expertise ENUM('PAP','JJM','PNK','TNL','BDI','KOM','Officer','YO','Admin')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert Officer back to PKOR
        \DB::table('instructors')
            ->where('expertise', 'Officer')
            ->update(['expertise' => 'PKOR']);

        // Revert the enum to include PKOR
        \DB::statement("ALTER TABLE instructors MODIFY COLUMN expertise ENUM('PAP','JJM','PNK','TNL','BDI','KOM','PKOR','YO','Admin')");
    }
};
