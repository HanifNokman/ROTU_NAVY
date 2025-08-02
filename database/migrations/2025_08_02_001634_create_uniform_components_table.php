<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniformComponentsTable extends Migration
{
    public function up()
    {
        Schema::create('uniform_components', function (Blueprint $table) {
            $table->id();
            $table->string('uniform_id')->nullable(); // Can be used to group components by uniform type
            $table->string('component_name');
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index('component_name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('uniform_components');
    }
}
