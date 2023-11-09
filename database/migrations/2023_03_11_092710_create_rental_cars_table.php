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
        Schema::create('rental_cars', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number');
            $table->decimal('cost')->nullable();
            $table->integer('seats');
            $table->string('model');
            $table->date('next_cof_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_cars');
    }
};
