<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            if (!Schema::hasColumn('room_types', 'category')) {
                $table->string('category', 20)->default('single')->after('slug');
            }
        });

        DB::table('room_types')->where('slug', 'single-room')->update(['category' => 'single']);
        DB::table('room_types')->where('slug', 'double-room')->update(['category' => 'double']);
        DB::table('room_types')->where('slug', 'family-room')->update(['category' => 'family']);

        DB::table('room_types')->where('name', 'like', '%Single%')->whereNull('category')->update(['category' => 'single']);
        DB::table('room_types')->where('name', 'like', '%Double%')->update(['category' => 'double']);
        DB::table('room_types')->where('name', 'like', '%Family%')->update(['category' => 'family']);
    }

    public function down(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            if (Schema::hasColumn('room_types', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};
