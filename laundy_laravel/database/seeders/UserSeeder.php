<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $akun = [
            ['Admin Laundry',   'admin@laundry.test',   'admin'],
            ['Petugas Laundry', 'petugas@laundry.test', 'petugas'],
            ['Pemilik Laundry', 'pemilik@laundry.test', 'pemilik'],
        ];

        foreach ($akun as [$name, $email, $role]) {
            User::updateOrCreate(
                ['email' => $email],
                ['name' => $name, 'password' => 'password', 'role' => $role]
            );
        }
    }
}
