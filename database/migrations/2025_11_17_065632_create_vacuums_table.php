<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bins', function (Blueprint $table) {
            $table->id();
            $table->string('bin_id')->unique();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('device_id')->nullable();
            $table->string('location')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->integer('capacity')->nullable();
            $table->float('tank_height_cm')->nullable();
            $table->float('distance_cm')->nullable();
            $table->integer('moisture')->nullable();
            $table->integer('moisture_percent')->nullable();
            $table->string('moisture_status')->nullable();
            $table->string('last_sort_result')->nullable();
            $table->boolean('sensor_error')->default(false);
            $table->timestamp('last_seen_at')->nullable();
            $table->integer('battery')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('homebase_id')->nullable();
            $table->timestamp('last_emptied')->nullable();
            $table->boolean('full_logged')->default(false);
            $table->string('task_status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bins');
    }
};
