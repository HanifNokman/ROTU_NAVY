<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('equipment_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cadet_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->constrained('inventory_items')->onDelete('cascade');
            $table->integer('quantity');
            $table->date('borrow_date');
            $table->date('return_date')->nullable();
            $table->enum('status', ['Borrowed', 'Pending Return', 'Returned', 'Overdue'])->default('Borrowed');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment_loans');
    }
};
