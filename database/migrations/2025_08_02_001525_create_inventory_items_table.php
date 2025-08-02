<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryItemsTable extends Migration
{
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['Uniform', 'Equipment']);
            $table->integer('total_quantity')->default(0);
            $table->integer('available_quantity')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index(['category', 'name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_items');
    }
}
