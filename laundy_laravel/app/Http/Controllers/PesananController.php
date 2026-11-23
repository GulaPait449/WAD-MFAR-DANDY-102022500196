<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PesananController extends Controller
{
    public function index()
    {
        return $this->tampil();
    }


    public function edit(Pesanan $pesanan)
    {
        return $this->tampil($pesanan);
    }

    public function store(Request $request)
    {
        Pesanan::create($this->validasi($request));
        return redirect()->route('pesanan.index')->with('pesan', 'Pesanan berhasil disimpan');
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $pesanan->update($this->validasi($request, true));
        return redirect()->route('pesanan.index')->with('pesan', 'Pesanan berhasil diubah');
    }

    public function destroy(Pesanan $pesanan)
    {
        $pesanan->delete();
        return redirect()->route('pesanan.index')->with('pesan', 'Pesanan berhasil dihapus');
    }

    private function tampil($edit = null)
    {
        return view('pesanan.index', [
            'layanan'       => Layanan::orderBy('harga')->get(),
            'pesanan'       => Pesanan::with('layanan')->latest('id')->get(),
            'edit'          => $edit,
            'daftar_status' => Pesanan::STATUS,
        ]);
    }

    private function validasi(Request $request, $ubah = false)
    {
        $rules = [
            'nama'       => ['required', 'string', 'max:100'],
            'telepon'    => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'layanan_id' => ['required', 'exists:layanan,id'],
            'jumlah'     => ['required', 'numeric', 'min:0.5', 'max:9999'],
            'alamat'     => ['nullable', 'string'],
        ];

        if ($ubah) {
            $rules['status'] = ['required', Rule::in(Pesanan::STATUS)];
        }

        return $request->validate($rules);
    }
}