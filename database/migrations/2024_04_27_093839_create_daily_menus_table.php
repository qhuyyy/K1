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
        Schema::create('daily_menus', function (Blueprint $table) {
            $table->id();
            $table->date('Date')->unique();
            $table->integer('NumberOfPortions');
            $table->unsignedBigInteger('Dish1_ID')->nullable();
            $table->foreign('Dish1_ID')->references('id')->on('dishes')->onDelete('cascade');
            $table->unsignedBigInteger('Dish2_ID')->nullable();
            $table->foreign('Dish2_ID')->references('id')->on('dishes')->onDelete('cascade');
            $table->unsignedBigInteger('Dish3_ID')->nullable();
            $table->foreign('Dish3_ID')->references('id')->on('dishes')->onDelete('cascade');
            $table->unsignedBigInteger('Dish4_ID')->nullable();
            $table->foreign('Dish4_ID')->references('id')->on('dishes')->onDelete('cascade');
            $table->unsignedBigInteger('Dish5_ID')->nullable();
            $table->foreign('Dish5_ID')->references('id')->on('dishes')->onDelete('cascade');
            $table->unsignedBigInteger('Dish6_ID')->nullable();
            $table->foreign('Dish6_ID')->references('id')->on('dishes')->onDelete('cascade');
            $table->unsignedBigInteger('Dish7_ID')->nullable();
            $table->foreign('Dish7_ID')->references('id')->on('dishes')->onDelete('cascade');
            $table->unsignedBigInteger('Dish8_ID')->nullable();
            $table->foreign('Dish8_ID')->references('id')->on('dishes')->onDelete('cascade');
            $table->unsignedBigInteger('Dish9_ID')->nullable();
            $table->foreign('Dish9_ID')->references('id')->on('dishes')->onDelete('cascade');
            $table->unsignedBigInteger('Dish10_ID')->nullable();
            $table->foreign('Dish10_ID')->references('id')->on('dishes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_menus');
    }
};
