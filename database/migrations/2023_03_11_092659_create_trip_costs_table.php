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
        Schema::create('trip_costs', function (Blueprint $table) {
            $table->id();
            $table->decimal('fuel', 8, 2);
            $table->decimal('wages', 8, 2)->nullable();
            $table->decimal('others', 8, 2)->nullable();
            $table->decimal('gifts', 8, 2)->nullable();
            $table->decimal('rental_fee', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_costs');
    }
};
