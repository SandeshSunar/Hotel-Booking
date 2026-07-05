<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Make room_id and user_id nullable
            $table->foreignId('room_id')->nullable()->change();
            $table->foreignId('user_id')->nullable()->change();

            // Drop deprecated columns if they exist
            if (Schema::hasColumn('bookings', 'check_in_date')) {
                $table->dropColumn('check_in_date');
            }
            if (Schema::hasColumn('bookings', 'check_out_date')) {
                $table->dropColumn('check_out_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('room_id')->nullable(false)->change();
            $table->foreignId('user_id')->nullable(false)->change();

            if (!Schema::hasColumn('bookings', 'check_in_date')) {
                $table->date('check_in_date')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'check_out_date')) {
                $table->date('check_out_date')->nullable();
            }
        });
    }
};
