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
    Schema::create('pesanan', function (Blueprint $table) {
        $table->id();
        $table->string('nama', 100);
        $table->string('telepon', 20);
        $table->foreignId('layanan_id')->constrained('layanan');
        $table->decimal('jumlah', 6, 1)->default(1);
        $table->text('alamat')->nullable();
        $table->enum('status', ['Baru', 'Diproses', 'Selesai', 'Diambil'])->default('Baru');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
