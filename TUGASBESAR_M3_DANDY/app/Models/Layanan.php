<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';
    public $timestamps = false; 
    protected $fillable = ['jenis', 'nama', 'harga', 'satuan', 'estimasi'];
}