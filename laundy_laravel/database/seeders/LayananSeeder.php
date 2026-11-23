<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        Layanan::create([
            'jenis' => 'satuan',
            'nama' => 'Laundry Satuan',
            'harga' => 7000,
            'satuan' => 'pcs',
            'estimasi' => '1-2 hari',
        ]);

        Layanan::create([
            'jenis' => 'kiloan',
            'nama' => 'Laundry Kiloan',
            'harga' => 13000,
            'satuan' => 'kg',
            'estimasi' => '2-4 hari',
        ]);

        Layanan::create([
            'jenis' => 'express',
            'nama' => 'Laundry Express',
            'harga' => 17000,
            'satuan' => 'kg',
            'estimasi' => '1 hari',
        ]);
    }
}