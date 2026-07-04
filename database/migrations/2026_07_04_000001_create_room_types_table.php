<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('room_number')->nullable();
            $table->text('description');
            $table->string('short_description')->nullable();
            $table->decimal('price_per_night', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('room_size')->nullable();
            $table->string('bed_type')->nullable();
            $table->unsignedTinyInteger('capacity_adults')->default(1);
            $table->unsignedTinyInteger('capacity_children')->default(0);
            $table->unsignedInteger('total_rooms')->default(1);
            $table->unsignedInteger('available_rooms')->default(1);
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
