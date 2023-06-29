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
        Schema::create('doctors_specializations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('doctor_id');
            $table->bigInteger('specialization_id');

            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('specialization_id')->references('id')->on('specializations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors_specializations');
    }
};
