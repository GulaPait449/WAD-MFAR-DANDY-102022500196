@extends('layouts.app')

@section('content')
  <header class="hero">
    <h1>Daftar Layanan dan Tarif Laundry</h1>
    <p class="subtitle">Kelola paket cuci, harga, dan estimasi waktu</p>
  </header>

  @if (session('pesan'))
    <div class="alert ok">{{ session('pesan') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert error">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Form tambah / ubah: hanya untuk yang berhak --}}
  @if ($edit ? auth()->user()->can('layanan.edit') : auth()->user()->can('layanan.tambah'))
    <section class="Pesan">
      <h3>{{ $edit ? 'Ubah Layanan #' . $edit->id : 'Tambah Layanan' }}</h3>

      <form method="POST" action="{{ $edit ? route('layanan.update', $edit) : route('layanan.store') }}">
        @csrf
        @if ($edit) @method('PUT') @endif

        <label for="jenis">Jenis (kode unik, mis. kiloan)</label>
        <input type="text" id="jenis" name="jenis" value="{{ old('jenis', $edit->jenis ?? '') }}" required>

        <label for="nama">Nama Layanan</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', $edit->nama ?? '') }}" required>

        <label for="harga">Harga (Rp)</label>
        <input type="number" id="harga" name="harga" min="0" value="{{ old('harga', $edit->harga ?? '') }}" required>

        <label for="satuan">Satuan (kg / pcs)</label>
        <input type="text" id="satuan" name="satuan" value="{{ old('satuan', $edit->satuan ?? '') }}" required>

        <label for="estimasi">Estimasi Waktu</label>
        <input type="text" id="estimasi" name="estimasi" value="{{ old('estimasi', $edit->estimasi ?? '') }}" required>

        <button type="submit" class="btn">{{ $edit ? 'Simpan Perubahan' : 'Tambah Layanan' }}</button>
        @if ($edit) <a class="link" href="{{ route('layanan.index') }}">Batal</a> @endif
      </form>
    </section>
  @endif

  <h2>Data Layanan</h2>
  <div class="table-wrap">
    <table>
      <tr>
        <th>No</th><th>Jenis</th><th>Nama</th><th>Harga</th><th>Estimasi</th>
        @canany(['layanan.edit', 'layanan.hapus']) <th>Aksi</th> @endcanany
      </tr>

      @forelse ($layanan as $l)
        <tr>
          <td>{{ $l->id }}</td>
          <td>{{ $l->jenis }}</td>
          <td>{{ $l->nama }}</td>
          <td>Rp{{ number_format($l->harga, 0, ',', '.') }} / {{ $l->satuan }}</td>
          <td>{{ $l->estimasi }}</td>
          @canany(['layanan.edit', 'layanan.hapus'])
            <td class="aksi">
              @can('layanan.edit')
                <a class="btn btn-sm" href="{{ route('layanan.edit', $l) }}">Edit</a>
              @endcan
              @can('layanan.hapus')
                <form class="inline-form" method="POST" action="{{ route('layanan.destroy', $l) }}"
                      onsubmit="return confirm('Yakin hapus layanan ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
              @endcan
            </td>
          @endcanany
        </tr>
      @empty
        <tr><td colspan="6">Belum ada layanan.</td></tr>
      @endforelse
    </table>
  </div>
@endsection
