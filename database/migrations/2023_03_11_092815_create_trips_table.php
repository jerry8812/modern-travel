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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('trip_number')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('source')->nullable();
            $table->string('status');
            
            $table->foreignId('trip_cost_id')->nullable();

            $table->foreign('trip_cost_id')->references('id')->on('trip_costs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
