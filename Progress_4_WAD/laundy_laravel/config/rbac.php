<?php

/*
|--------------------------------------------------------------------------
| Matriks Hak Akses (RBAC)
|--------------------------------------------------------------------------
| Format: 'modul' => ['role' => ['aksi', ...]]
| Aksi: lihat, tambah, edit, hapus
| Ability yang terbentuk: "<modul>.<aksi>", contoh: layanan.hapus
| Saat merge repo tim, tiap anggota cukup menambah modulnya di sini
| (mesin, pelanggan, bahan) lalu memakai middleware can:<modul>.<aksi>.
*/

$admin   = ['lihat', 'tambah', 'edit', 'hapus'];
$petugas = ['lihat', 'tambah', 'edit'];
$pemilik = ['lihat'];

return [
    'roles' => ['admin', 'petugas', 'pemilik'],

    'modul' => [
        'layanan' => ['admin' => $admin, 'petugas' => $petugas, 'pemilik' => $pemilik],
        'pesanan' => ['admin' => $admin, 'petugas' => $petugas, 'pemilik' => $pemilik],
        // 'mesin'     => [...],   // Individu B
        // 'pelanggan' => [...],   // Individu C
        // 'bahan'     => [...],   // Individu D
    ],
];
