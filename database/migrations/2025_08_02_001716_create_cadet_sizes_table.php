<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cadet_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadet_id')->constrained()->onDelete('cascade');
            $table->foreignId('component_id')->constrained('uniform_components')->onDelete('cascade');
            $table->string('size')->nullable();
            $table->boolean('is_issued')->default(false);
            $table->timestamps();
            
            $table->unique(['cadet_id', 'component_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cadet_sizes');
    }
};
