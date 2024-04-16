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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('Name',50);
            $table->date('DateOfBirth');
            $table->string('CICN',12)->unique();
            $table->char('PhoneNumber',10)->unique();
            $table->string('Image')->nullable();

            $table->unsignedBigInteger('Position_ID');
            $table->foreign('Position_ID')->references('id')->on('positions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
