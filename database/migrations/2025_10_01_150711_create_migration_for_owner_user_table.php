<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // On récupère les utilisateurs qui ont encore un owner_id
        DB::table('users')
    //->whereNotNull('owner_id')
    ->orderBy('id') // <-- obligatoire
    ->chunk(100, function ($users) {
        foreach ($users as $user) {
            DB::table('owner_user')->insert([
                'owner_id' => 1,
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       DB::table('owner_user')->truncate();
    }
};
