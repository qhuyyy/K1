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
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->string('DishName',50)->unique();
            $table->unsignedBigInteger('DishType_ID');
            $table->foreign('DishType_ID')->references('id')->on('dish_types')->onDelete('cascade');
            $table->unsignedBigInteger('Ingredient1_ID');
            $table->foreign('Ingredient1_ID')->references('id')->on('ingredients')->onDelete('cascade');
            $table->unsignedBigInteger('Ingredient2_ID')->nullable();
            $table->foreign('Ingredient2_ID')->references('id')->on('ingredients')->onDelete('cascade');
            $table->unsignedBigInteger('Ingredient3_ID')->nullable();
            $table->foreign('Ingredient3_ID')->references('id')->on('ingredients')->onDelete('cascade');
            $table->unsignedBigInteger('Ingredient4_ID')->nullable();
            $table->foreign('Ingredient4_ID')->references('id')->on('ingredients')->onDelete('cascade');
            $table->unsignedBigInteger('Ingredient5_ID')->nullable();
            $table->foreign('Ingredient5_ID')->references('id')->on('ingredients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dishes');
    }
};
