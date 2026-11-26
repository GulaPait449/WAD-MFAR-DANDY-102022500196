<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mesin', function (Blueprint $table) {
            $table->increments('id'); // sudah otomatis primary key + auto increment
            $table->string('nama', 100);
            $table->string('jenis', 50);
            $table->string('merek', 50);
            $table->integer('kapasitas');
            $table->string('status', 30);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mesin');
    }
};