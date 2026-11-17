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
    Schema::create('layanan', function (Blueprint $table) {
        $table->id();
        $table->string('jenis', 20)->unique();
        $table->string('nama', 50);
        $table->unsignedInteger('harga');
        $table->string('satuan', 10);
        $table->string('estimasi', 30);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
