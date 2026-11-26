<?php

namespace App\Http\Controllers; //nentuin kelompok tempat class

use App\Models\Mesin; //memungkinkan menggunakan class model mesin
use Illuminate\Http\Request; //menggunakan fitur req laravel (membaca informasi yang dikirim pengguna melalui website)

class MesinController extends Controller 
{
    // Menampilkan daftar mesin
    public function index() 
    {
        $mesin = Mesin::all(); // $ digunakan untuk membuat atau mengakses variabel di PHP
        // $nama menyimpan teks Mesin Cuci A
        // $kapasitas menyimpan angka 10

        // Mesin::all() mengambil semua data
        // $mesin -> mengambil semua data mesin
        return view('mesin.index', compact('mesin')); //mengirim data ke halaman untuk ditampilkan
        // view('mesin.index') -> index blade (file yang mengatur tampilan daftar mesin)
        // compact ('mesin') -> kirim data ke index blade biar bisa nampilin daftar mesin

    }

    // Menampilkan form tambah mesin
    public function create() // menampilkan formulir kosong tambah mesin, bukan untuk menyimpan data ke database
    {
        return view('mesin.create'); // meminta laravel menampilkan halaman mesin.create
    }

    // Menyimpan mesin baru
    public function store(Request $request) //menerima data yang dikirim dari formulir
    //$req untuk mengakses data yang dikirim pengguna
    {
        $data = $request->validate([ //mengambil data dari formulir dan memeriksa apakah data tersebut sudah memenuhi aturan yang ditentukan
            'nama' => 'required|string|max:255', //kolom nama wajib diisi, berupa teks, max 255
            'jenis' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'kapasitas' => 'required|numeric|min:1', //nilainya min 1
            'status' => 'required|string|max:255',
        ]);

        Mesin::create($data); // menyimpan data yang sudah lolos validasi ke db melalui model mesin

        return redirect('/') //mengarahkan pengguna kembali ke halaman utama setelah data berhasil disimpan
            ->with('success', 'Data mesin berhasil ditambahkan.'); // mengirim pesan sukses
    }

    // Menampilkan form edit mesin
    public function edit($id) //menampilkan formulir edit berdasarkan id mesin(identitas) yg dipilih
    {
        $mesin = Mesin::findOrFail($id); //mencari data mesin di db berdasarkan $id, lalu menyimpan ke $mesin,
        //kalo gaketemu, laravel kirim halaman error 404

        return view('mesin.edit', compact('mesin')); //nampilin halaman edit.blade dan mengirim data mesin yg ditemukan ke halaman tsb 
    }

    // Memperbarui data mesin
    public function update(Request $request, $id) //membuat fungsi update untuk memperbarui data mesin
    {
        $mesin = Mesin::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'merek' => 'required|string|max:255',
            'kapasitas' => 'required|numeric|min:1',
            'status' => 'required|string|max:255',
        ]);

        $mesin->update($data); //memperbarui data mesin menggunakan data baru yg tersimpan di $data

        return redirect('/')
            ->with('success', 'Data mesin berhasil diperbarui.');
    }
    
    // Menghapus data mesin
    public function destroy($id) //menghapus data mesin berdasarkan $id yg dipilih
    {
        $mesin = Mesin::findOrFail($id);
        $mesin->delete();

        return redirect('/')
            ->with('success', 'Data mesin berhasil dihapus.');
    }

}
