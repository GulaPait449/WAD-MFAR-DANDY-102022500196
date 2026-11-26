<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Daftarkan ability "<modul>.<aksi>" dari config/rbac.php
        foreach (config('rbac.modul', []) as $modul => $perRole) {
            foreach (['lihat', 'tambah', 'edit', 'hapus'] as $aksi) {
                Gate::define("$modul.$aksi", fn (User $user) => $user->izin($modul, $aksi));
            }
        }
    }
}
