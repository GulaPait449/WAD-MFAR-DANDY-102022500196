<?php

namespace App\Http\Controllers;

use App\Models\StokLaundry;
use Illuminate\Http\Request;

class StokLaundryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $stok_list = StokLaundry::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('jenis', 'like', "%{$search}%");
        })->orderBy('id', 'desc')->get();

        return view('stok.index', compact('stok_list', 'search'));
    }

    public function create()
    {
        return view('stok.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:deterjen,pewangi,pelembut,merk bahan,supplier',
            'rincian' => 'required|in:penambahan,pengurangan',
            'berat' => 'required|numeric|min:0',
        ]);

        StokLaundry::create($request->all());

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil disimpan!');
    }

    public function edit($id)
    {
        $stok = StokLaundry::findOrFail($id);
        return view('stok.edit', compact('stok'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jenis' => 'required|in:deterjen,pewangi,pelembut,merk bahan,supplier',
            'rincian' => 'required|in:penambahan,pengurangan',
            'berat' => 'required|numeric|min:0',
        ]);

        $stok = StokLaundry::findOrFail($id);
        $stok->update($request->all());

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil diubah!');
    }

    public function destroy($id)
    {
        $stok = StokLaundry::findOrFail($id);
        $stok->delete();

        return redirect()->route('stok.index')->with('success', 'Data stok berhasil dihapus!');
    }
}