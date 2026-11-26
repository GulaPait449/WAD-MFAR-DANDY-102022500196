@csrf

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

<div class="form-group">
    <label for="nama">Nama Lengkap</label>
    <input type="text" id="nama" name="nama" class="form-input"
           value="{{ old('nama', $pelanggan->nama ?? '') }}"
           placeholder="Contoh: Budi Santoso" required>
</div>

<div class="form-group">
    <label for="nomortelpon">Nomor Telepon / WhatsApp</label>
    <input type="tel" id="nomortelpon" name="nomortelpon" class="form-input"
           value="{{ old('nomortelpon', $pelanggan->nomortelpon ?? '') }}"
           placeholder="Contoh: 081234567890" required>
</div>

<div class="form-group">
    <label for="alamat">Alamat Pelanggan</label>
    <textarea id="alamat" name="alamat" rows="3" class="form-input">{{ old('alamat', $pelanggan->alamat ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="catatan">Catatan Penanganan Khusus Pakaian</label>
    <textarea id="catatan" name="catatan" rows="4" class="form-input"
              placeholder="Contoh: Baju putih jangan dicampur.">{{ old('catatan', $pelanggan->catatan ?? '') }}</textarea>
</div>

<div style="display: flex; gap: 10px; margin-top: 24px;">
    <button type="submit" class="btn-primary">Simpan Data</button>
    <a href="{{ route('pelanggan.index') }}" class="btn-secondary" style="text-decoration: none;">Batal</a>
</div>
