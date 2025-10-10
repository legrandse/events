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
        Schema::create('owner_user', function (Blueprint $table) {
            $table->id();
		    $table->foreignId('owner_id')->constrained()->cascadeOnDelete();
		    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
		    $table->timestamps();

		    $table->unique(['owner_id', 'user_id']); // éviter les doublons
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owner_user');
    }
};
