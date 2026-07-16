<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->string('type')->nullable();
            $table->string('source')->nullable();
            $table->boolean('is_new')->default(true);
            $table->boolean('has_check')->default(false);
            $table->string('bin_code')->nullable();
            $table->string('homebase_id')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('task_status')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
