<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('room_type_facilities')->truncate();

        Schema::table('room_type_facilities', function (Blueprint $table) {
            $table->dropColumn(['name', 'icon']);
            $table->foreignId('facility_id')->after('room_type_id')->constrained('facilities')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_type_facilities', function (Blueprint $table) {
            $table->dropForeign(['facility_id']);
            $table->dropColumn('facility_id');
            $table->string('name');
            $table->string('icon')->nullable();
        });

        Schema::dropIfExists('facilities');
    }
};
