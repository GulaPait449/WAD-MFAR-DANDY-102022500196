<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan_biodata';

    protected $fillable = ['nama', 'nomortelpon', 'alamat', 'catatan'];
}
