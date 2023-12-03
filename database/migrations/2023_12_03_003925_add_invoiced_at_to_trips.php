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
        Schema::table('trips', function (Blueprint $table) {
            $table->date('invoiced_at')->nullable();
            $table->decimal('total_invoiced')->nullable();
            $table->decimal('total_cost', 8, 2)->default(0);
            $table->string('rental_car_model')->nullable();
            $table->boolean('is_cancelled')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn('invoiced_at');
            $table->dropColumn('total_invoiced');
            $table->dropColumn('total_cost');
            $table->dropColumn('rental_car_model');
            $table->dropColumn('is_cancelled');
        });
    }
};
