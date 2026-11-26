<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Stok Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow p-4 bg-white">
        <h2 class="text-center mb-4">Daftar Stok Laundry</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('stok.create') }}" class="btn btn-success">+ Tambah Stok</a>
            
            <form action="{{ route('stok.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau jenis..." value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Rincian</th>
                        <th>Berat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stok_list as $index => $stok)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $stok->nama }}</td>
                            <td>{{ $stok->tanggal }}</td>
                            <td>{{ ucfirst($stok->jenis) }}</td>
                            <td>{{ ucfirst($stok->rincian) }}</td>
                            <td>{{ number_format((float)$stok->berat, 2, ',', '.') }} kg</td>
                            <td class="text-center">
                                <a href="{{ route('stok.edit', $stok->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                
                                <form action="{{ route('stok.destroy', $stok->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>