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
        Schema::create('menu_dishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Menu_ID');
            $table->foreign('Menu_ID')->references('id')->on('menus')->onDelete('cascade');
            $table->unsignedBigInteger('Dish_ID');
            $table->foreign('Dish_ID')->references('id')->on('dishes')->onDelete('cascade');
            $table->integer('NumberOfPortions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_dishes');
    }
};
