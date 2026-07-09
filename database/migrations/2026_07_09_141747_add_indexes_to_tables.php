<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->index('status');
            $table->index('customer_id');
            $table->index('driver_id');
            $table->index('created_at');
        });

        Schema::table('destinations', function (Blueprint $table) {
            $table->index('category');
            $table->index('is_active');
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->index('is_active');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['customer_id']);
            $table->dropIndex(['driver_id']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('destinations', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
