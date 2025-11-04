<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('owner_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained()->cascadeOnDelete();
            $table->foreignId('setting_id')->constrained()->cascadeOnDelete();
            $table->string('value')->nullable();
            $table->timestamps();

            $table->unique(['owner_id', 'setting_id']); // optionnel : éviter les doublons
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owner_settings');
    }
};
