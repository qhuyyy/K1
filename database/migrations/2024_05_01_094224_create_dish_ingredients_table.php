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
        Schema::create('dish_ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Dish_ID');
            $table->foreign('Dish_ID')->references('id')->on('dishes')->onDelete('cascade');
            $table->unsignedBigInteger('Ingredient_ID');
            $table->foreign('Ingredient_ID')->references('id')->on('ingredients')->onDelete('cascade');
            $table->decimal('Amount',8,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dish_ingredients');
    }
};
