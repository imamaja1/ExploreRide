<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('driver')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->string('whatsapp')->nullable()->after('phone');
            $table->text('address')->nullable()->after('whatsapp');
            $table->string('plate_number')->nullable()->after('address');
            $table->string('sim_photo')->nullable()->after('plate_number');
            $table->boolean('is_active')->default(true)->after('sim_photo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'whatsapp', 'address', 'plate_number', 'sim_photo', 'is_active']);
        });
    }
};
