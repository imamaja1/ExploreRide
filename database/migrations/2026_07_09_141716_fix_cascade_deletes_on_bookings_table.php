<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['car_id']);
            $table->dropForeign(['service_id']);

            $table->foreign('customer_id')->references('id')->on('customers')->restrictOnDelete();
            $table->foreign('car_id')->references('id')->on('cars')->restrictOnDelete();
            $table->foreign('service_id')->references('id')->on('services')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['car_id']);
            $table->dropForeign(['service_id']);

            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->foreign('car_id')->references('id')->on('cars')->cascadeOnDelete();
            $table->foreign('service_id')->references('id')->on('services')->cascadeOnDelete();
        });
    }
};
