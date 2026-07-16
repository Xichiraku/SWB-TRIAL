<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('history_logs', function (Blueprint $table) {
            $table->id();
            $table->string('bin_id')->nullable();
            $table->string('bin_name')->nullable();
            $table->string('homebase_id')->nullable();
            $table->string('status')->nullable();
            $table->text('message')->nullable();
            $table->string('operator_id')->nullable();
            $table->string('triggered_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('history_logs');
    }
};
