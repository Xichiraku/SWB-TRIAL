<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homebases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable();
            $table->string('status')->nullable();
            $table->integer('vacuum_assigned')->nullable();
            $table->integer('active_vacuums')->nullable();
            $table->float('temperature')->nullable();
            $table->string('power_status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homebases');
    }
};
