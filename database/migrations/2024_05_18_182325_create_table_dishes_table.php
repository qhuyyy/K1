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
        Schema::create('table_dishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Table_ID');
            $table->foreign('Table_ID')->references('id')->on('tables')->onDelete('cascade');
            $table->unsignedBigInteger('Dish_ID');
            $table->foreign('Dish_ID')->references('id')->on('dishes')->onDelete('cascade');
            $table->integer('NumberOfDishes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_dishes');
    }
};
