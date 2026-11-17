<?php

namespace Tests\Feature;

use App\Models\Layanan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $role): User
    {
        return User::factory()->create(['role' => $role]);
    }

    private function layanan(): Layanan
    {
        return Layanan::create(['jenis' => 'kiloan', 'nama' => 'Kiloan', 'harga' => 13000, 'satuan' => 'kg', 'estimasi' => '2 hari']);
    }

    private function payload(array $o = []): array
    {
        return array_merge(['jenis' => 'express', 'nama' => 'Express', 'harga' => 17000, 'satuan' => 'kg', 'estimasi' => '1 hari'], $o);
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $this->get('/layanan')->assertRedirect('/login');
    }

    public function test_semua_role_bisa_melihat(): void
    {
        foreach (['admin', 'petugas', 'pemilik'] as $role) {
            $this->actingAs($this->user($role))->get('/layanan')->assertOk();
        }
    }

    public function test_pemilik_hanya_lihat(): void
    {
        $l = $this->layanan();
        $u = $this->user('pemilik');

        $this->actingAs($u)->post('/layanan', $this->payload())->assertForbidden();
        $this->actingAs($u)->get("/layanan/{$l->id}/edit")->assertForbidden();
        $this->actingAs($u)->put("/layanan/{$l->id}", $this->payload())->assertForbidden();
        $this->actingAs($u)->delete("/layanan/{$l->id}")->assertForbidden();
    }

    public function test_petugas_bisa_tambah_edit_tapi_tidak_hapus(): void
    {
        $l = $this->layanan();
        $u = $this->user('petugas');

        $this->actingAs($u)->post('/layanan', $this->payload())->assertRedirect('/layanan');
        $this->actingAs($u)->put("/layanan/{$l->id}", $this->payload(['jenis' => 'kiloan', 'nama' => 'Baru']))->assertRedirect('/layanan');
        $this->assertDatabaseHas('layanan', ['id' => $l->id, 'nama' => 'Baru']);
        $this->actingAs($u)->delete("/layanan/{$l->id}")->assertForbidden();
        $this->assertDatabaseHas('layanan', ['id' => $l->id]);
    }

    public function test_admin_bisa_semuanya(): void
    {
        $l = $this->layanan();
        $u = $this->user('admin');

        $this->actingAs($u)->post('/layanan', $this->payload())->assertRedirect('/layanan');
        $this->actingAs($u)->delete("/layanan/{$l->id}")->assertRedirect('/layanan');
        $this->assertDatabaseMissing('layanan', ['id' => $l->id]);
    }

    public function test_tombol_ui_mengikuti_role(): void
    {
        $this->layanan();

        $this->actingAs($this->user('pemilik'))->get('/layanan')
            ->assertDontSee('Tambah Layanan')->assertDontSee('Hapus');
        $this->actingAs($this->user('petugas'))->get('/layanan')
            ->assertSee('Tambah Layanan')->assertDontSee('Hapus');
        $this->actingAs($this->user('admin'))->get('/layanan')
            ->assertSee('Tambah Layanan')->assertSee('Hapus');
    }

    public function test_login_dan_logout(): void
    {
        $this->seed(\Database\Seeders\UserSeeder::class);

        $this->post('/login', ['email' => 'admin@laundry.test', 'password' => 'salah'])->assertSessionHasErrors('email');
        $this->post('/login', ['email' => 'admin@laundry.test', 'password' => 'password'])->assertRedirect('/layanan');
        $this->assertAuthenticated();
        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();
    }
}
