<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cadets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('intake_year')->nullable();
            $table->string('matric_no', 20)->nullable();
            $table->string('faculty')->nullable();
            $table->string('course')->nullable();
            $table->decimal('current_cgpa', 4, 2)->nullable();
            $table->decimal('past_cgpa', 4, 2)->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('ic_number', 14)->nullable();
            $table->enum('rank', ['PK','PKK','Lt M'])->nullable();
            $table->string('service_number', 20)->nullable();
            $table->enum('position', ['Normal','CO','Thana','Zayn','PMC'])->default('Normal');
            $table->enum('gender', ['Male','Female'])->nullable();
            $table->enum('cadet_status', ['Active','Suspended','Completed','Inactive'])->default('Active');
            $table->boolean('is_best_cadet')->default(false);
            $table->boolean('is_best_academic')->default(false);
            $table->integer('daily_duty_count')->nullable();
            $table->decimal('BMI', 4, 1)->nullable();
            $table->date('BMI_update_date')->nullable();
            $table->enum('swimming_qualification', ['Pass','In Progress','Fail'])->default('In Progress');
            $table->date('swimming_pass_date')->nullable();
            $table->date('ttp_date')->nullable();
            $table->string('insurance_number', 50)->nullable();
            $table->string('bank_account_number', 30)->nullable();
            $table->string('profile_pic')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('cadets');
    }
};
