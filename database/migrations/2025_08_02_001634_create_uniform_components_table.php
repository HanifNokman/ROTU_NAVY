<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('uniform_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uniform_type_id')->constrained()->onDelete('cascade');
            $table->string('component_name');
            $table->timestamps();
            
            $table->unique(['uniform_type_id', 'component_name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('uniform_components');
    }
};