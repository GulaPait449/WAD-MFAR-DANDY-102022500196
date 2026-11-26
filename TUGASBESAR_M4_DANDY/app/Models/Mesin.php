<?php

namespace App\Models;
// namespace -> cara mengelompokkan class agar laravel tau lokasinya

use Illuminate\Database\Eloquent\Model;
// eloquent -> fitur laravel yg memungkinkan mengelola db menggunakan php tanpa tulis sql manual

class Mesin extends Model
{
    public $timestamps = false; //laravel tidak perlu mengelola kolom create at & update at secara otomatis untuk model mesin
    // pake public karna dideklarasikan sebagai properti public

    protected $table = 'mesin'; // kalo model mesin dipake, pake tabel db yg naanya mesin
    //protected karna nama tabel cukup digunakan oleh model dan class turunannya
    protected $fillable = [ //kolom mana yang boleh diisi sekaligus saat menambahkan atau mengedit data mesin
     //pengaturan internal 
        'nama', 
        'jenis',
        'merek',
        'kapasitas',
        'status',
    ];
}
