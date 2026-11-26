<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow p-4 bg-white" style="max-width: 600px; margin: auto;">
        <h3 class="mb-4 text-center">Edit Stok Laundry</h3>
        
        <form action="{{ route('stok.update', $stok->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nama Bahan</label>
                <input type="text" class="form-control" name="nama" value="{{ old('nama', $stok->nama) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal', $stok->tanggal) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis</label>
                <select class="form-select" name="jenis" required>
                    <option value="deterjen" {{ $stok->jenis == 'deterjen' ? 'selected' : '' }}>Deterjen</option>
                    <option value="pewangi" {{ $stok->jenis == 'pewangi' ? 'selected' : '' }}>Pewangi</option>
                    <option value="pelembut" {{ $stok->jenis == 'pelembut' ? 'selected' : '' }}>Pelembut</option>
                    <option value="merk bahan" {{ $stok->jenis == 'merk bahan' ? 'selected' : '' }}>Merk Bahan</option>
                    <option value="supplier" {{ $stok->jenis == 'supplier' ? 'selected' : '' }}>Supplier</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Rincian</label>
                <select class="form-select" name="rincian" required>
                    <option value="penambahan" {{ $stok->rincian == 'penambahan' ? 'selected' : '' }}>Penambahan</option>
                    <option value="pengurangan" {{ $stok->rincian == 'pengurangan' ? 'selected' : '' }}>Pengurangan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Berat</label>
                <input type="number" step="0.01" class="form-control" name="berat" value="{{ old('berat', $stok->berat) }}" required>
            </div>

            <button type="submit" class="btn btn-warning w-100 text-white">Update Stok</button>
        </form>
    </div>
</div>

</body>
</html>