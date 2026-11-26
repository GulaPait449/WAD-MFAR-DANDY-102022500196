<x-app-layout>

    <!-- HEADER HALAMAN -->
    <div class="welcome-banner">
        <h1>Edit Data Mesin 🧺</h1>
        <p>
            Perbarui informasi mesin dan peralatan laundry
            yang sudah terdaftar.
        </p>
    </div>

    <!-- FORM EDIT MESIN -->
    <div class="info-panel">

        <h2 style="margin-bottom: 8px;">
            Form Edit Mesin
        </h2>

        <p style="color: #8290A3; font-size: 13px; margin-bottom: 24px;">
            Periksa dan perbarui informasi mesin di bawah ini.
        </p>

        <!-- PESAN VALIDASI -->
        @if ($errors->any())
            <div class="error-list" style="margin-bottom: 20px;">
                <strong>Terjadi kesalahan:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM EDIT -->
        <form action="{{ route('mesin.update', $mesin->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- NAMA MESIN -->
            <div class="form-group">
                <label for="nama">Nama Mesin</label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="form-input"
                    value="{{ old('nama', $mesin->nama) }}"
                    required
                >
            </div>

            <!-- JENIS MESIN -->
            <div class="form-group">
                <label for="jenis">Jenis Mesin</label>

                <select id="jenis" name="jenis" class="form-input" required>
                    <option value="Mesin Cuci"
                        {{ old('jenis', $mesin->jenis) == 'Mesin Cuci' ? 'selected' : '' }}>
                        Mesin Cuci
                    </option>

                    <option value="Mesin Pengering"
                        {{ old('jenis', $mesin->jenis) == 'Mesin Pengering' ? 'selected' : '' }}>
                        Mesin Pengering
                    </option>
                </select>
            </div>

            <!-- MEREK -->
            <div class="form-group">
                <label for="merek">Merek</label>

                <input
                    type="text"
                    id="merek"
                    name="merek"
                    class="form-input"
                    value="{{ old('merek', $mesin->merek) }}"
                    required
                >
            </div>

            <!-- KAPASITAS -->
            <div class="form-group">
                <label for="kapasitas">Kapasitas (kg)</label>

                <input
                    type="number"
                    id="kapasitas"
                    name="kapasitas"
                    class="form-input"
                    value="{{ old('kapasitas', $mesin->kapasitas) }}"
                    min="1"
                    required
                >
            </div>

            <!-- STATUS -->
            <div class="form-group">
                <label for="status">Status</label>

                <select id="status" name="status" class="form-input" required>
                    <option value="Operasional"
                        {{ old('status', $mesin->status) == 'Operasional' ? 'selected' : '' }}>
                        Operasional
                    </option>

                    <option value="Perawatan"
                        {{ old('status', $mesin->status) == 'Perawatan' ? 'selected' : '' }}>
                        Perawatan
                    </option>

                    <option value="Rusak"
                        {{ old('status', $mesin->status) == 'Rusak' ? 'selected' : '' }}>
                        Rusak
                    </option>
                </select>
            </div>

            <!-- TOMBOL -->
            <div style="display: flex; gap: 10px; margin-top: 24px;">

                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>

                <a href="{{ route('mesin.index') }}"
                   class="btn-secondary"
                   style="text-decoration: none;">
                    Batal
                </a>

            </div>

        </form>

    </div>

</x-app-layout>
