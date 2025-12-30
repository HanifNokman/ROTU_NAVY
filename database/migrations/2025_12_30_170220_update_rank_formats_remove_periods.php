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
        // Update cadets table - change rank format from period to space
        \DB::statement("UPDATE cadets SET rank = 'Lt M' WHERE rank = 'Lt.M'");

        // Update instructors table - change rank formats from period to space
        \DB::statement("UPDATE instructors SET rank = 'Lt M' WHERE rank = 'Lt.M'");
        \DB::statement("UPDATE instructors SET rank = 'Lt Dya' WHERE rank = 'Lt.Dya'");
        \DB::statement("UPDATE instructors SET rank = 'Lt Kdr' WHERE rank = 'Lt.Kdr'");

        // Alter the ENUM columns to use new format
        \DB::statement("ALTER TABLE cadets MODIFY COLUMN rank ENUM('PK','PKK','Lt M')");
        \DB::statement("ALTER TABLE instructors MODIFY COLUMN rank ENUM('LKII','LKI','LK','BM','BK','PWI','PWII','Lt M','Lt Dya','Lt','Lt Kdr','Kdr','Kpt')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert cadets table - change rank format from space to period
        \DB::statement("UPDATE cadets SET rank = 'Lt.M' WHERE rank = 'Lt M'");

        // Revert instructors table - change rank formats from space to period
        \DB::statement("UPDATE instructors SET rank = 'Lt.M' WHERE rank = 'Lt M'");
        \DB::statement("UPDATE instructors SET rank = 'Lt.Dya' WHERE rank = 'Lt Dya'");
        \DB::statement("UPDATE instructors SET rank = 'Lt.Kdr' WHERE rank = 'Lt Kdr'");

        // Alter the ENUM columns to use old format
        \DB::statement("ALTER TABLE cadets MODIFY COLUMN rank ENUM('PK','PKK','Lt.M')");
        \DB::statement("ALTER TABLE instructors MODIFY COLUMN rank ENUM('LKII','LKI','LK','BM','BK','PWI','PWII','Lt.M','Lt.Dya','Lt','Lt.Kdr','Kdr','Kpt')");
    }
};
