<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('position', 50)->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->enum('rank', ['LKII','LKI','LK','BM','BK','PWI','PWII','Lt.M','Lt.Dya','Lt','Lt.Kdr','Kdr','Kpt'])->nullable();
            $table->enum('expertise', ['PAP','JJM','PNK','TNL','BDI','KOM','PKOR','Admin'])->nullable();
            $table->integer('time_in_service')->nullable();
            $table->date('ttp')->nullable();
            $table->enum('status', ['Active','Relocated','Retired'])->default('Active');
            $table->string('service_number', 20)->nullable();
            $table->string('past_unit', 100)->nullable();
            $table->timestamps();
        });

        // Seed first instructor user and instructor profile
        if (\DB::table('users')->count() === 0) {
            $userId = \DB::table('users')->insertGetId([
                'name' => 'Hanif Nokman',
                'email' => 'hanifnokman02@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // bcrypt('password')
                'role' => 'instructor',
                'status' => 'accepted',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            \DB::table('instructors')->insert([
                'user_id' => $userId,
                'position' => 'Admin',
                'phone_number' => '0123456789',
                'rank' => 'Lt.M',
                'expertise' => 'Admin',
                'time_in_service' => 1,
                'ttp' => now(),
                'status' => 'Active',
                'service_number' => 'NV/8709199',
                'past_unit' => 'PALAPES LAUT UMS',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    public function down()
    {
        Schema::dropIfExists('instructors');
    }
};
