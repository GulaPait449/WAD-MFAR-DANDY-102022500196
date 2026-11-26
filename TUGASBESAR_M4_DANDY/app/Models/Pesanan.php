<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    public const STATUS = ['Baru', 'Diproses', 'Selesai', 'Diambil'];

    protected $table = 'pesanan';
    protected $fillable = ['nama', 'telepon', 'layanan_id', 'jumlah', 'alamat', 'status'];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function getTotalAttribute()
    {
        return $this->jumlah * $this->layanan->harga;
    }
}