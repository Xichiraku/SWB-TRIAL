<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('notif_enabled')->default(true);
            $table->boolean('capacity_alert')->default(true);
            $table->boolean('battery_alert')->default(true);
            $table->boolean('nurse_alert')->default(true);
            $table->boolean('email_notif')->default(true);
            $table->boolean('push_notif')->default(false);
            $table->integer('collection_threshold')->default(85);
            $table->integer('battery_threshold')->default(20);
            $table->integer('refresh_interval')->default(30);
            $table->string('theme')->nullable();
            $table->string('language')->nullable();
            $table->string('units')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
