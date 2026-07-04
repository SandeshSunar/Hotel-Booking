<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'room_type_id')) {
                $table->foreignId('room_type_id')->nullable()->after('id')->constrained('room_types')->nullOnDelete();
            }
            if (!Schema::hasColumn('bookings', 'guest_id')) {
                $table->foreignId('guest_id')->nullable()->after('room_type_id')->constrained('guests')->nullOnDelete();
            }
            if (!Schema::hasColumn('bookings', 'guest_name')) {
                $table->string('guest_name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('bookings', 'email')) {
                $table->string('email')->nullable()->after('guest_name');
            }
            if (!Schema::hasColumn('bookings', 'phone')) {
                $table->string('phone', 20)->nullable()->after('email');
            }
            if (!Schema::hasColumn('bookings', 'check_in')) {
                $table->date('check_in')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('bookings', 'check_out')) {
                $table->date('check_out')->nullable()->after('check_in');
            }
            if (!Schema::hasColumn('bookings', 'adults')) {
                $table->unsignedTinyInteger('adults')->default(1)->after('check_out');
            }
            if (!Schema::hasColumn('bookings', 'children')) {
                $table->unsignedTinyInteger('children')->default(0)->after('adults');
            }
            if (!Schema::hasColumn('bookings', 'rooms_count')) {
                $table->unsignedTinyInteger('rooms_count')->default(1)->after('children');
            }
            if (!Schema::hasColumn('bookings', 'special_requests')) {
                $table->text('special_requests')->nullable()->after('rooms_count');
            }
            if (!Schema::hasColumn('bookings', 'total_price')) {
                $table->decimal('total_price', 10, 2)->default(0)->after('special_requests');
            }
        });

        if (Schema::hasColumn('bookings', 'check_in_date')) {
            DB::table('bookings')
                ->whereNull('check_in')
                ->update([
                    'check_in' => DB::raw('check_in_date'),
                    'check_out' => DB::raw('check_out_date'),
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $columns = [
                'room_type_id', 'guest_id', 'guest_name', 'email', 'phone',
                'check_in', 'check_out', 'adults', 'children', 'rooms_count',
                'special_requests', 'total_price',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('bookings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
