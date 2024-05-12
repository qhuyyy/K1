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
        Schema::create('bill_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Bill_ID');
            $table->foreign('Bill_ID')->references('id')->on('bills')->onDelete('cascade');
            $table->unsignedBigInteger('Product_ID');
            $table->foreign('Product_ID')->references('id')->on('products')->onDelete('cascade');
            $table->integer('Quantity');
            $table->integer('SubTotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_products');
    }
};
