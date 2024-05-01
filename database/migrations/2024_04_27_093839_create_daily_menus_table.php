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
            $table->integer('NumberOfTotalPortions');
            for ($i = 1; $i <= 10; $i++) {
                $table->unsignedBigInteger("Dish{$i}_ID")->nullable();
                $table->foreign("Dish{$i}_ID")->references('id')->on('dishes')->onDelete('cascade');
                $table->integer("NumberOfPortions{$i}")->nullable();
            }
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
