<x-app-layout>

    <!-- HEADER HALAMAN -->
    <div class="welcome-banner">
        <h1>Mesin & Peralatan 🧺</h1>
        <p>
            Kelola data mesin, kapasitas, merek, dan status
            operasional laundry.
        </p>
    </div>

    <!-- PESAN BERHASIL -->
    @if (session('success'))
        <div class="info-panel" style="margin-bottom: 20px; border-left: 5px solid #22B8A7;">
            {{ session('success') }}
        </div>
    @endif

    <!-- PESAN VALIDASI -->
    @if ($errors->any())
        <div class="info-panel" style="margin-bottom: 20px;">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- DAFTAR MESIN -->
    <div class="info-panel">

        <div style="display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap; margin-bottom: 24px;">

            <div>
                <h2 style="margin-bottom: 5px;">
                    Daftar Mesin & Peralatan
                </h2>

                <p style="color: #8290A3; font-size: 13px;">
                    Berikut merupakan data mesin dan peralatan laundry.
                </p>
            </div>

            @if (in_array(auth()->user()->role, ['admin', 'petugas']))
                <a href="{{ route('mesin.create') }}"
                   class="btn-primary"
                   style="text-decoration: none;">
                    + Tambah Mesin
                </a>
            @endif

        </div>

        <!-- TABEL -->
        <div class="table-container">
            <table>

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Mesin</th>
                        <th>Jenis</th>
                        <th>Merek</th>
                        <th>Kapasitas (kg)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($mesin as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->nama }}</td>

                            <td>{{ $item->jenis }}</td>

                            <td>{{ $item->merek }}</td>

                            <td>{{ $item->kapasitas }}</td>

                            <!-- STATUS -->
                            <td>
                                @if ($item->status == 'Operasional')
                                    <span class="status operasional">
                                        {{ $item->status }}
                                    </span>
                                @elseif ($item->status == 'Perawatan')
                                    <span class="status perawatan">
                                        {{ $item->status }}
                                    </span>
                                @else
                                    <span class="status rusak">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>

                            <!-- AKSI -->
                            <td class="aksi">

                                @if (in_array(auth()->user()->role, ['admin', 'petugas']))
                                    <a href="{{ route('mesin.edit', $item->id) }}"
                                       class="btn btn-warning">
                                        Edit
                                    </a>
                                @endif

                                @if (auth()->user()->role == 'admin')
                                    <form
                                        action="{{ route('mesin.destroy', $item->id) }}"
                                        method="POST"
                                        class="form-hapus">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="button"
                                            class="btn btn-danger"
                                            onclick="bukaPopupHapus(this)">
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
                            <td colspan="7" style="text-align: center; padding: 25px;">
                                Belum ada data mesin.
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

            <h2>Hapus Data Mesin?</h2>

            <p>
                Apakah kamu yakin ingin menghapus data mesin ini?
            </p>

            <p class="popup-note">
                Data yang dihapus tidak dapat dikembalikan.
            </p>

            <div class="popup-actions">

                <button
                    type="button"
                    class="btn-secondary"
                    onclick="tutupPopupHapus()">
                    Batal
                </button>

                <button
                    type="button"
                    class="btn btn-danger"
                    onclick="konfirmasiHapus()">
                    Ya, Hapus
                </button>

            </div>

        </div>
    </div>

    <!-- JAVASCRIPT POPUP -->
    <script>
        let formYangAkanDihapus = null;

        function bukaPopupHapus(button) {
            formYangAkanDihapus = button.closest('form');

            document
                .getElementById('popupHapus')
                .classList.add('aktif');
        }

        function tutupPopupHapus() {
            document
                .getElementById('popupHapus')
                .classList.remove('aktif');

            formYangAkanDihapus = null;
        }

        function konfirmasiHapus() {
            if (formYangAkanDihapus) {
                formYangAkanDihapus.submit();
            }
        }
    </script>

</x-app-layout>
