<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadetSizesTable extends Migration
{
    public function up()
    {
        Schema::create('cadet_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadet_id')->constrained()->onDelete('cascade');
            $table->foreignId('component_id')->constrained('uniform_components')->onDelete('cascade');
            $table->string('size', 10);
            $table->boolean('is_issued')->default(false);
            $table->date('issued_date')->nullable();
            $table->timestamps();
            
            $table->unique(['cadet_id', 'component_id']);
            $table->index(['component_id', 'size']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cadet_sizes');
    }
}
