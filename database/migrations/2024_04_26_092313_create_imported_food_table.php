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
        Schema::create('imported_food', function (Blueprint $table) {
            $table->id();
            $table->date('Date');
            $table->unsignedBigInteger('FoodType_ID');
            $table->foreign('FoodType_ID')->references('id')->on('food_types')->onDelete('cascade');
            $table->string('FoodName',50);
            $table->unsignedBigInteger('Unit_ID');
            $table->foreign('Unit_ID')->references('id')->on('units')->onDelete('cascade');
            $table->integer('UnitPrice');
            $table->decimal('Quantity', 10, 2);
            $table->decimal('Total',10, 2);
            $table->string('Note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imported_food');
    }
};
