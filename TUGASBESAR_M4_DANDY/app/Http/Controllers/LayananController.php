<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LayananController extends Controller
{
    public function index()
    {
        return $this->tampil();
    }

    public function edit(Layanan $layanan)
    {
        return $this->tampil($layanan);
    }

    public function store(Request $request)
    {
        Layanan::create($this->validasi($request));
        return redirect()->route('layanan.index')->with('pesan', 'Layanan berhasil ditambahkan');
    }

    public function update(Request $request, Layanan $layanan)
    {
        $layanan->update($this->validasi($request, $layanan));
        return redirect()->route('layanan.index')->with('pesan', 'Layanan berhasil diubah');
    }

    public function destroy(Layanan $layanan)
    {
        if ($layanan->pesanan()->exists()) {
            return redirect()->route('layanan.index')
                ->withErrors(['hapus' => 'Layanan tidak bisa dihapus karena sudah dipakai pada pesanan.']);
        }

        $layanan->delete();
        return redirect()->route('layanan.index')->with('pesan', 'Layanan berhasil dihapus');
    }

    private function tampil($edit = null)
    {
        return view('layanan.index', [
            'layanan' => Layanan::orderBy('harga')->get(),
            'edit'    => $edit,
        ]);
    }

    private function validasi(Request $request, ?Layanan $layanan = null)
    {
        return $request->validate([
            'jenis'    => ['required', 'string', 'max:20', Rule::unique('layanan', 'jenis')->ignore($layanan?->id)],
            'nama'     => ['required', 'string', 'max:50'],
            'harga'    => ['required', 'integer', 'min:0'],
            'satuan'   => ['required', 'string', 'max:10'],
            'estimasi' => ['required', 'string', 'max:30'],
        ]);
    }
}
