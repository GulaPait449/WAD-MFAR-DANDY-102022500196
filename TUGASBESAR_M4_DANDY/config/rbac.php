<?php

/*
|--------------------------------------------------------------------------
| Matriks Hak Akses (RBAC)
|--------------------------------------------------------------------------
| Format: 'modul' => ['role' => ['aksi', ...]]
| Aksi: lihat, tambah, edit, hapus
| Ability yang terbentuk: "<modul>.<aksi>", contoh: layanan.hapus
| Tiap anggota cukup menambah modulnya di sini (pelanggan, bahan, dst.)
| lalu memakai middleware can:<modul>.<aksi> atau @can('<modul>.<aksi>').
*/

$admin   = ['lihat', 'tambah', 'edit', 'hapus'];
$petugas = ['lihat', 'tambah', 'edit'];
$pemilik = ['lihat'];

return [
    'roles' => ['admin', 'petugas', 'pemilik'],

    'modul' => [
        'layanan' => ['admin' => $admin, 'petugas' => $petugas, 'pemilik' => $pemilik],
        'pesanan' => ['admin' => $admin, 'petugas' => $petugas, 'pemilik' => $pemilik],
        'mesin'   => ['admin' => $admin, 'petugas' => $petugas, 'pemilik' => $pemilik],
        'pelanggan' => ['admin' => $admin, 'petugas' => $petugas, 'pemilik' => $pemilik],
        // 'bahan'     => [...],   // modul anggota lain
    ],
];
