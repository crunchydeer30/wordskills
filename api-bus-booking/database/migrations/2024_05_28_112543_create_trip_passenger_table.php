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
        Schema::create('trip_passenger', function (Blueprint $table) {
            $table->foreignId('trip_id')->references('id')->on('trips');
            $table->foreignId('passenger_id')->references('id')->on('trips');
            $table->unique(['trip_id', 'passenger_id']);
            $table->primary(['trip_id', 'passenger_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_passenger');
    }
};
