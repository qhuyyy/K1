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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->date('Date');
            $table->unsignedBigInteger('Customer_ID');
            $table->foreign('Customer_ID')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('BillType_ID');
            $table->foreign('BillType_ID')->references('id')->on('bill_types')->onDelete('cascade');
            $table->integer('Extra')->nullable();
            $table->integer('Prepaid')->nullable();
            $table->integer('Total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
