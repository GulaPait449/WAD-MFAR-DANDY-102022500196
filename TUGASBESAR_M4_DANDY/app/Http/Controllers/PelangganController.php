<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    private function rules(): array
    {
        return [
            'nama'        => ['required', 'string', 'max:255'],
            'nomortelpon' => ['required', 'regex:/^[0-9+]{8,20}$/'],
            'alamat'      => ['nullable', 'string'],
            'catatan'     => ['nullable', 'string'],
        ];
    }

    private function messages(): array
    {
        return [
            'nomortelpon.regex' => 'Nomor telepon harus 8-20 karakter berupa angka (boleh diawali +).',
        ];
    }

    public function index()
    {
        $pelanggan = Pelanggan::latest()->get();

        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        Pelanggan::create($request->validate($this->rules(), $this->messages()));

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil disimpan.');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $pelanggan->update($request->validate($this->rules(), $this->messages()));

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diubah.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
