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
        Schema::create('doctors_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subscription_id');
            $table->bigInteger('doctor_id');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('subscription_id')->references('id')->on('subscriptions');
            $table->foreign('doctor_id')->references('id')->on('doctors_profile');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors_subscriptions');
    }
};
