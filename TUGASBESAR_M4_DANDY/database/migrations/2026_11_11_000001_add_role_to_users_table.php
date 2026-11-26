<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kolom role sudah dibuat di create_users_table; lewati agar tidak "duplicate column"
        if (Schema::hasColumn('users', 'role')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            // admin | petugas | pemilik
            $table->string('role', 20)->default('petugas')->after('password');
        });
    }

    public function down(): void
    {
        // Kolom milik create_users_table; tidak di-drop di sini
    }
};
