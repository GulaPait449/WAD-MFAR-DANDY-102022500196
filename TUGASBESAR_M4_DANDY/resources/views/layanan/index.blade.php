<x-app-layout>

    <!-- HEADER HALAMAN -->
    <div class="welcome-banner">
        <h1>Layanan & Tarif 💰</h1>
        <p>
            Kelola paket layanan laundry, harga, dan estimasi
            waktu pengerjaan.
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

    <!-- FORM TAMBAH / UBAH (hanya untuk yang berhak) -->
    @if ($edit ? auth()->user()->can('layanan.edit') : auth()->user()->can('layanan.tambah'))
        <div class="info-panel lt-mb">
            <h2>{{ $edit ? 'Ubah Layanan #' . $edit->id : 'Tambah Layanan' }}</h2>
            <p class="lt-sub">
                {{ $edit ? 'Perbarui data layanan di bawah ini.' : 'Isi data layanan baru di bawah ini.' }}
            </p>

            <form method="POST"
                  action="{{ $edit ? route('layanan.update', $edit) : route('layanan.store') }}">
                @csrf
                @if ($edit) @method('PUT') @endif

                <div class="lt-form-grid">
                    <div class="form-group">
                        <label for="jenis">Jenis (kode unik, mis. kiloan)</label>
                        <input type="text" id="jenis" name="jenis" class="form-input"
                               value="{{ old('jenis', $edit->jenis ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Layanan</label>
                        <input type="text" id="nama" name="nama" class="form-input"
                               value="{{ old('nama', $edit->nama ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" id="harga" name="harga" min="0" class="form-input"
                               value="{{ old('harga', $edit->harga ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="satuan">Satuan (kg / pcs)</label>
                        <input type="text" id="satuan" name="satuan" class="form-input"
                               value="{{ old('satuan', $edit->satuan ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="estimasi">Estimasi Waktu</label>
                        <input type="text" id="estimasi" name="estimasi" class="form-input"
                               value="{{ old('estimasi', $edit->estimasi ?? '') }}" required>
                    </div>
                </div>

                <div class="lt-form-actions">
                    <button type="submit" class="btn-primary">
                        {{ $edit ? 'Simpan Perubahan' : '+ Tambah Layanan' }}
                    </button>

                    @if ($edit)
                        <a href="{{ route('layanan.index') }}" class="btn-secondary lt-link-btn">Batal</a>
                    @endif
                </div>
            </form>
        </div>
    @endif

    <!-- DAFTAR LAYANAN -->
    <div class="info-panel">

        <div class="lt-panel-head">
            <h2>Daftar Layanan & Tarif</h2>
            <p class="lt-sub">Berikut merupakan paket layanan yang tersedia di laundry.</p>
        </div>

        <div class="table-container">
            <table class="lt-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Jenis</th>
                        <th>Nama Layanan</th>
                        <th>Harga</th>
                        <th>Estimasi</th>
                        @canany(['layanan.edit', 'layanan.hapus'])
                            <th>Aksi</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody>
                    @forelse ($layanan as $l)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="status info">{{ $l->jenis }}</span></td>
                            <td>{{ $l->nama }}</td>
                            <td>Rp{{ number_format($l->harga, 0, ',', '.') }} / {{ $l->satuan }}</td>
                            <td>{{ $l->estimasi }}</td>

                            @canany(['layanan.edit', 'layanan.hapus'])
                                <td>
                                    <div class="aksi">
                                        @can('layanan.edit')
                                            <a href="{{ route('layanan.edit', $l) }}" class="btn-warning">Edit</a>
                                        @endcan

                                        @can('layanan.hapus')
                                            <form action="{{ route('layanan.destroy', $l) }}"
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
                            <td colspan="6" class="lt-empty">Belum ada layanan.</td>
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

            <h2>Hapus Layanan?</h2>

            <p>Apakah kamu yakin ingin menghapus layanan ini?</p>

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
