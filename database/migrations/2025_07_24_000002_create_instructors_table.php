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
            $table->enum('rank', ['LKII','LKI','LK','BM','BK','PWI','PWII','Lt M','Lt Dya','Lt','Lt Kdr','Kdr','Kpt'])->nullable();
            $table->enum('expertise', ['PAP','JJM','PNK','TNL','BDI','KOM','Officer','YO','Admin'])->nullable();
            $table->integer('time_in_service')->nullable();
            $table->date('ttp')->nullable();
            $table->enum('status', ['Active','Relocated','Retired'])->default('Active');
            $table->string('service_number', 20)->nullable();
            $table->string('past_unit', 100)->nullable();
            $table->string('profile_pic')->nullable();
            $table->timestamps();
        });

        // Seed first instructor user and instructor profile
        if (\DB::table('users')->count() === 0) {
            $userId = \DB::table('users')->insertGetId([
                'name' => 'Hanif Nokman',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'instructor',
                'status' => 'accepted',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            \DB::table('instructors')->insert([
                'user_id' => $userId,
                'position' => 'Developer',
                'phone_number' => '',
                'rank' => 'Lt M',
                'expertise' => 'Admin',
                'time_in_service' => 3,
                'ttp' => now(),
                'status' => 'Active',
                'service_number' => '',
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
