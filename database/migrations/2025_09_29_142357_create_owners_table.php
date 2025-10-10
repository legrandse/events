<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('organisation')->nullable();
            $table->string('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('place')->nullable();
            $table->string('vat')->nullable();
            $table->foreignId('product_id')->nullable()->constrained('prices')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
