@extends('layouts.app')

@section('content')
  <header class="hero">
    <h1>Daftar Layanan dan Tarif Laundry</h1>
    <p class="subtitle">Pilih layanan yang paling sesuai dengan kebutuhan Anda</p>
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

  {{-- Kartu layanan --}}
  <section class="Card-grid">
    @foreach ($layanan as $l)
      <article class="card {{ $l->jenis == 'express' ? : '' }}">
        <h3>{{ $l->nama }}</h3>
        <p class="price">Rp{{ number_format($l->harga, 0, ',', '.') }} <span>/ {{ $l->satuan }}</span></p>
        <p class="time">Estimasi waktu: {{ $l->estimasi }}</p>
      </article>
    @endforeach
  </section>

  {{-- Form tambah / ubah --}}
  <section class="Pesan">
    <h3>{{ $edit ? 'Ubah Pesanan #' . $edit->id : 'Pesan Layanan' }}</h3>

    <form method="POST" action="{{ $edit ? route('pesanan.update', $edit) : route('pesanan.store') }}">
      @csrf
      @if ($edit) @method('PUT') @endif

      <label for="nama">Nama</label>
      <input type="text" id="nama" name="nama" value="{{ old('nama', $edit->nama ?? '') }}" required>

      <label for="telepon">No. HP</label>
      <input type="tel" id="telepon" name="telepon" value="{{ old('telepon', $edit->telepon ?? '') }}" required>

      <label for="layanan_id">Jenis Layanan</label>
      <select id="layanan_id" name="layanan_id" required>
        <option value="">-- Pilih layanan --</option>
        @foreach ($layanan as $l)
          <option value="{{ $l->id }}" @selected(old('layanan_id', $edit->layanan_id ?? '') == $l->id)>
            {{ $l->nama }}
          </option>
        @endforeach
      </select>

      <label for="jumlah">Jumlah (kg / pcs)</label>
      <input type="number" id="jumlah" name="jumlah" min="0.5" step="0.5"
             value="{{ old('jumlah', $edit->jumlah ?? 1) }}" required>

      @if ($edit)
        <label for="status">Status</label>
        <select id="status" name="status">
          @foreach ($daftar_status as $s)
            <option value="{{ $s }}" @selected(old('status', $edit->status) == $s)>{{ $s }}</option>
          @endforeach
        </select>
      @endif

      <label for="alamat">Alamat</label>
      <textarea id="alamat" name="alamat" rows="3">{{ old('alamat', $edit->alamat ?? '') }}</textarea>

      <button type="submit" class="btn">{{ $edit ? 'Simpan Perubahan' : 'Kirim Pesanan' }}</button>
    </form>
  </section>

  {{-- Tabel pesanan --}}
  <h2>Data Pesanan</h2>
  <div class="table-wrap">
    <table>
      <tr>
        <th>No</th><th>Nama</th><th>No. HP</th><th>Layanan</th>
        <th>Jumlah</th><th>Total</th><th>Status</th><th>Aksi</th>
      </tr>

      @forelse ($pesanan as $r)
        <tr>
          <td>{{ $r->id }}</td>
          <td>{{ $r->nama }}</td>
          <td>{{ $r->telepon }}</td>
          <td>{{ $r->layanan->nama }}</td>
          <td>{{ $r->jumlah }} {{ $r->layanan->satuan }}</td>
          <td>Rp{{ number_format($r->total, 0, ',', '.') }}</td>
          <td>{{ $r->status }}</td>
          <td class="aksi">
            <a class="btn btn-sm" href="{{ route('pesanan.edit', $r) }}">Edit</a>
            <form class="inline-form" method="POST" action="{{ route('pesanan.destroy', $r) }}"
                  onsubmit="return confirm('Yakin hapus pesanan ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="8">Belum ada pesanan.</td></tr>
      @endforelse
    </table>
  </div>
@endsection