<x-app-layout>

    <div class="welcome-banner">
        <h1>Data Pelanggan 👥</h1>
        <p>Kelola biodata, nomor telepon, dan catatan penanganan khusus pakaian.</p>
    </div>

    @if (session('success'))
        <div class="info-panel" style="margin-bottom: 20px; border-left: 5px solid #22B8A7;">
            {{ session('success') }}
        </div>
    @endif

    <div class="info-panel">

        <div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap; margin-bottom: 24px;">
            <div>
                <h2 style="margin-bottom: 5px;">Daftar Pelanggan</h2>
                <p style="color: #8290A3; font-size: 13px;">
                    Berikut merupakan data pelanggan laundry.
                </p>
            </div>

            @if (in_array(auth()->user()->role, ['admin', 'petugas']))
                <a href="{{ route('pelanggan.create') }}" class="btn-primary" style="text-decoration: none;">
                    + Tambah Pelanggan
                </a>
            @endif
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>No. Telp/WA</th>
                        <th>Alamat</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pelanggan as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->nomortelpon }}</td>
                            <td>{{ $p->alamat ?: '-' }}</td>
                            <td>{{ $p->catatan ?: '-' }}</td>

                            <td class="aksi">
                                @if (in_array(auth()->user()->role, ['admin', 'petugas']))
                                    <a href="{{ route('pelanggan.edit', $p) }}" class="btn btn-warning">Edit</a>
                                @endif

                                @if (auth()->user()->role == 'admin')
                                    <form action="{{ route('pelanggan.destroy', $p) }}" method="POST" class="form-hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger" onclick="bukaPopupHapus(this)">
                                            Hapus
                                        </button>
                                    </form>
                                @endif

                                @if (auth()->user()->role == 'pemilik')
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 25px;">
                                Belum ada data pelanggan.
                            </td>
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
            <h2>Hapus Data Pelanggan?</h2>
            <p>Apakah kamu yakin ingin menghapus data pelanggan ini?</p>
            <p class="popup-note">Data yang dihapus tidak dapat dikembalikan.</p>

            <div class="popup-actions">
                <button type="button" class="btn-secondary" onclick="tutupPopupHapus()">Batal</button>
                <button type="button" class="btn btn-danger" onclick="konfirmasiHapus()">Ya, Hapus</button>
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
