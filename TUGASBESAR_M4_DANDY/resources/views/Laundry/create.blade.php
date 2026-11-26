<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Stok Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow p-4 bg-white" style="max-width: 600px; margin: auto;">
        <h3 class="mb-4 text-center">Tambah Stok Baru</h3>
        
        <form action="<?= route('stok.store') ?>" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Nama Bahan</label>
                <input type="text" class="form-control" name="nama" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control" name="tanggal" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis</label>
                <select class="form-select" name="jenis" required>
                    <option value="" disabled selected>-- Pilih Jenis --</option>
                    <option value="deterjen">Deterjen</option>
                    <option value="pewangi">Pewangi</option>
                    <option value="pelembut">Pelembut</option>
                    <option value="merk bahan">Merk Bahan</option>
                    <option value="supplier">Supplier</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Rincian</label>
                <select class="form-select" name="rincian" required>
                    <option value="" disabled selected>-- Pilih Rincian --</option>
                    <option value="penambahan">Penambahan</option>
                    <option value="pengurangan">Pengurangan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Berat</label>
                <input type="number" step="0.01" class="form-control" name="berat" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">+ Tambah Stok</button>
        </form>
    </div>
</div>

</body>
</html>