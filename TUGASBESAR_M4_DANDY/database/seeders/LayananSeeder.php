<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['jenis' => 'satuan']  + ['nama' => 'Laundry Satuan', 'harga' =>  7000, 'satuan' => 'pcs', 'estimasi' => '1-2 hari'],
            ['jenis' => 'kiloan']  + ['nama' => 'Laundry Kiloan', 'harga' => 13000, 'satuan' => 'kg',  'estimasi' => '2-4 hari'],
            ['jenis' => 'express'] + ['nama' => 'Laundry Express','harga' => 17000, 'satuan' => 'kg',  'estimasi' => '1 hari'],
        ];

        // updateOrCreate: aman dijalankan berulang (tidak dobel / bentrok unique jenis)
        foreach ($data as $row) {
            Layanan::updateOrCreate(['jenis' => $row['jenis']], $row);
        }
    }
}
