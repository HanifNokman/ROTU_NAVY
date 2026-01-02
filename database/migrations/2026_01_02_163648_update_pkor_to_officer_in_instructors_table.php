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
        // First, modify the enum to include both PKOR and Officer temporarily
        \DB::statement("ALTER TABLE instructors MODIFY COLUMN expertise ENUM('PAP','JJM','PNK','TNL','BDI','KOM','PKOR','Officer','YO','Admin')");

        // Update existing records with PKOR to Officer
        \DB::table('instructors')
            ->where('expertise', 'PKOR')
            ->update(['expertise' => 'Officer']);

        // Finally, remove PKOR from the enum, keeping only Officer
        \DB::statement("ALTER TABLE instructors MODIFY COLUMN expertise ENUM('PAP','JJM','PNK','TNL','BDI','KOM','Officer','YO','Admin')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First, modify the enum to include both Officer and PKOR temporarily
        \DB::statement("ALTER TABLE instructors MODIFY COLUMN expertise ENUM('PAP','JJM','PNK','TNL','BDI','KOM','PKOR','Officer','YO','Admin')");

        // Revert Officer back to PKOR
        \DB::table('instructors')
            ->where('expertise', 'Officer')
            ->update(['expertise' => 'PKOR']);

        // Finally, remove Officer from the enum, keeping only PKOR
        \DB::statement("ALTER TABLE instructors MODIFY COLUMN expertise ENUM('PAP','JJM','PNK','TNL','BDI','KOM','PKOR','YO','Admin')");
    }
};
