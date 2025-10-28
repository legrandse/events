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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('max_events')->nullable()->after('price'); // remplace existing_column si tu veux placer la colonne à un endroit précis
            $table->integer('max_volunteers')->nullable()->after('max_events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['max_events', 'max_volunteers']);
        });
    }
};
