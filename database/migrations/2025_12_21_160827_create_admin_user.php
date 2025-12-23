<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Создаем админ-аккаунт
        DB::table('users')->insert([
            'name' => 'Администратор',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role' => 2, // 2 = admin
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('email', 'admin@admin.com')->delete();
    }
};
