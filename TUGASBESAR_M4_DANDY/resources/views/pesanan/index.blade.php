<x-app-layout>

    <!-- HEADER HALAMAN -->
    <div class="welcome-banner">
        <h1>Pesanan 📋</h1>
        <p>
            Catat pesanan pelanggan dan pantau status
            pengerjaan laundry.
        </p>
    </div>

    <!-- PESAN BERHASIL -->
    @if (session('pesan'))
        <div class="info-panel lt-flash lt-mb">
            {{ session('pesan') }}
        </div>
    @endif

    <!-- PESAN VALIDASI -->
    @if ($errors->any())
        <div class="error-list lt-mb">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- KARTU LAYANAN -->
    <h2 class="section-title">Layanan Tersedia</h2>

    <div class="stats-grid">
        @foreach ($layanan as $l)
            <div class="module-card">
                <h3>{{ $l->nama }}</h3>
                <p class="lt-price">
                    Rp{{ number_format($l->harga, 0, ',', '.') }}
                    <span>/ {{ $l->satuan }}</span>
                </p>
                <p>Estimasi waktu: {{ $l->estimasi }}</p>
            </div>
        @endforeach
    </div>

    <!-- FORM TAMBAH / UBAH -->
    @if ($edit ? auth()->user()->can('pesanan.edit') : auth()->user()->can('pesanan.tambah'))
        <div class="info-panel lt-mb">
            <h2>{{ $edit ? 'Ubah Pesanan #' . $edit->id : 'Tambah Pesanan' }}</h2>
            <p class="lt-sub">
                {{ $edit ? 'Perbarui data pesanan di bawah ini.' : 'Isi data pelanggan dan layanan yang dipesan.' }}
            </p>

            <form method="POST"
                  action="{{ $edit ? route('pesanan.update', $edit) : route('pesanan.store') }}">
                @csrf
                @if ($edit) @method('PUT') @endif

                <div class="lt-form-grid">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-input"
                               value="{{ old('nama', $edit->nama ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="telepon">No. HP</label>
                        <input type="tel" id="telepon" name="telepon" class="form-input"
                               value="{{ old('telepon', $edit->telepon ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="layanan_id">Jenis Layanan</label>
                        <select id="layanan_id" name="layanan_id" class="form-input" required>
                            <option value="">-- Pilih layanan --</option>
                            @foreach ($layanan as $l)
                                <option value="{{ $l->id }}"
                                    @selected(old('layanan_id', $edit->layanan_id ?? '') == $l->id)>
                                    {{ $l->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah (kg / pcs)</label>
                        <input type="number" id="jumlah" name="jumlah" min="0.5" step="0.5"
                               class="form-input"
                               value="{{ old('jumlah', $edit->jumlah ?? 1) }}" required>
                    </div>

                    @if ($edit)
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-input">
                                @foreach ($daftar_status as $s)
                                    <option value="{{ $s }}" @selected(old('status', $edit->status) == $s)>
                                        {{ $s }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="form-group lt-full">
                        <label for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3"
                                  class="form-input">{{ old('alamat', $edit->alamat ?? '') }}</textarea>
                    </div>
                </div>

                <div class="lt-form-actions">
                    <button type="submit" class="btn-primary">
                        {{ $edit ? 'Simpan Perubahan' : '+ Kirim Pesanan' }}
                    </button>

                    @if ($edit)
                        <a href="{{ route('pesanan.index') }}" class="btn-secondary lt-link-btn">Batal</a>
                    @endif
                </div>
            </form>
        </div>
    @endif

    <!-- DAFTAR PESANAN -->
    <div class="info-panel">

        <div class="lt-panel-head">
            <h2>Daftar Pesanan</h2>
            <p class="lt-sub">Berikut merupakan pesanan pelanggan yang tercatat.</p>
        </div>

        <div class="table-container">
            <table class="lt-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>No. HP</th>
                        <th>Layanan</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Status</th>
                        @canany(['pesanan.edit', 'pesanan.hapus'])
                            <th>Aksi</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pesanan as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $r->nama }}</td>
                            <td>{{ $r->telepon }}</td>
                            <td>{{ $r->layanan->nama }}</td>
                            <td>{{ $r->jumlah }} {{ $r->layanan->satuan }}</td>
                            <td>Rp{{ number_format($r->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="status {{ strtolower($r->status) }}">{{ $r->status }}</span>
                            </td>

                            @canany(['pesanan.edit', 'pesanan.hapus'])
                                <td>
                                    <div class="aksi">
                                        @can('pesanan.edit')
                                            <a href="{{ route('pesanan.edit', $r) }}" class="btn-warning">Edit</a>
                                        @endcan

                                        @can('pesanan.hapus')
                                            <form action="{{ route('pesanan.destroy', $r) }}"
                                                  method="POST" class="form-hapus">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn-danger"
                                                        onclick="bukaPopupHapus(this)">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            @endcanany
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="lt-empty">Belum ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    <!-- POPUP KONFIRMASI HAPUS -->
    <div id="popupHapus" class="popup-overlay">
        <div class="popup-box">
            <div class="popup-icon">!</div>

            <h2>Hapus Pesanan?</h2>

            <p>Apakah kamu yakin ingin menghapus pesanan ini?</p>

            <p class="popup-note">Data yang dihapus tidak dapat dikembalikan.</p>

            <div class="popup-actions">
                <button type="button" class="btn-secondary" onclick="tutupPopupHapus()">Batal</button>
                <button type="button" class="btn-danger" onclick="konfirmasiHapus()">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
        let formYangAkanDihapus = null;

        function bukaPopupHapus(button) {
            formYangAkanDihapus = button.closest('form');
            document.getElementById('popupHapus').classList.add('aktif');
        }

        function tutupPopupHapus() {
            document.getElementById('popupHapus').classList.remove('aktif');
            formYangAkanDihapus = null;
        }

        function konfirmasiHapus() {
            if (formYangAkanDihapus) {
                formYangAkanDihapus.submit();
            }
        }
    </script>

</x-app-layout>
