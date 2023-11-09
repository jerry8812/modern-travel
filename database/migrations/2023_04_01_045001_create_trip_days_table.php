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
        Schema::create('trip_days', function (Blueprint $table) {
            $table->id();
            $table->integer('day_number');
            $table->date('date');
            $table->string('location');
            $table->decimal('rental_fee', 8, 2)->default(0);
            $table->string('comment')->nullable();
            $table->foreignId('rental_car_id')->nullable();
            $table->foreignId('tour_guide_id')->nullable();
            $table->foreignId('trip_id');

            $table->foreign('trip_id')->references('id')->on('trips')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('rental_car_id')->references('id')->on('rental_cars');
            $table->foreign('tour_guide_id')->references('id')->on('tour_guides');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_days');
    }
};
