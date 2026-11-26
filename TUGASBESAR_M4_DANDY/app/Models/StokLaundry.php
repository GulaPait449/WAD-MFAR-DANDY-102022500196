<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokLaundry extends Model
{
    //
}
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokLaundry extends Model
{
    use HasFactory;

    protected $table = 'stok_laundry';
    protected $fillable = ['nama', 'tanggal', 'jenis', 'rincian', 'berat'];
}