<?php

namespace Tests\Feature;

use App\Models\Period;
use App\Models\ProfilDewan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilDewanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_profil_dewan_page_only_shows_the_active_period(): void
    {
        $active = Period::query()->where('is_active', true)->firstOrFail();

        ProfilDewan::query()->create([
            'nama_lengkap' => 'Ketua Uji',
            'nim' => '99999999',
            'jabatan' => 'Ketua Umum',
            'periode' => $active->name,
            'status' => 'Aktif',
        ]);

        ProfilDewan::query()->create([
            'nama_lengkap' => 'Ketua Lama',
            'nim' => '99999998',
            'jabatan' => 'Ketua Umum',
            'periode' => '2023/2024',
            'status' => 'Aktif',
        ]);

        $this->get(route('profil-dewan.index'))
            ->assertOk()
            ->assertSee('Ketua Uji')
            ->assertSee($active->name)
            ->assertDontSee('Ketua Lama');
    }

    public function test_profil_dewan_page_hides_empty_komisi_sections(): void
    {
        ProfilDewan::query()->update(['status' => 'Selesai']);

        $active = Period::query()->where('is_active', true)->firstOrFail();

        ProfilDewan::query()->create([
            'nama_lengkap' => 'Ketua Tunggal',
            'nim' => '99999997',
            'jabatan' => 'Ketua Umum',
            'periode' => $active->name,
            'status' => 'Aktif',
        ]);

        $this->get(route('profil-dewan.index'))
            ->assertOk()
            ->assertSee('Ketua Tunggal')
            ->assertDontSee('Komisi I')
            ->assertDontSee('Komisi IV');
    }

    public function test_profil_dewan_page_shows_archived_period_on_request(): void
    {
        $active = Period::query()->where('is_active', true)->firstOrFail();
        $arsip = Period::query()->where('is_active', false)->firstOrFail();

        ProfilDewan::query()->create([
            'nama_lengkap' => 'Ketua Aktif',
            'nim' => '99999992',
            'jabatan' => 'Ketua Umum',
            'periode' => $active->name,
            'status' => 'Aktif',
        ]);

        ProfilDewan::query()->create([
            'nama_lengkap' => 'Ketua Arsip',
            'nim' => '99999995',
            'jabatan' => 'Ketua Umum',
            'periode' => $arsip->name,
            'status' => 'Selesai',
        ]);

        $this->get(route('profil-dewan.index', ['periode' => $arsip->name]))
            ->assertOk()
            ->assertSee('Ketua Arsip')
            ->assertDontSee('Ketua Aktif');

        $this->get(route('profil-dewan.index'))
            ->assertOk()
            ->assertSee('Ketua Aktif')
            ->assertDontSee('Ketua Arsip');
    }

    public function test_profil_dewan_page_groups_members_by_komisi(): void
    {
        $active = Period::query()->where('is_active', true)->firstOrFail();

        ProfilDewan::query()->create([
            'nama_lengkap' => 'Ketua Commission Tiga',
            'nim' => '99999994',
            'jabatan' => 'Ketua Komisi III',
            'periode' => $active->name,
            'status' => 'Aktif',
        ]);

        ProfilDewan::query()->create([
            'nama_lengkap' => 'Anggota Commission Dua',
            'nim' => '99999993',
            'jabatan' => 'Anggota Komisi II',
            'periode' => $active->name,
            'status' => 'Aktif',
        ]);

        $this->get(route('profil-dewan.index'))
            ->assertOk()
            ->assertSee('id="komisi-2"', false)
            ->assertSee('id="komisi-3"', false)
            ->assertSee('Ketua Commission Tiga')
            ->assertSee('Anggota Commission Dua');
    }

    public function test_profil_dewan_detail_lists_every_task_from_the_database(): void
    {
        $active = Period::query()->where('is_active', true)->firstOrFail();

        ProfilDewan::query()->create([
            'nama_lengkap' => 'Sekretaris Uji',
            'nim' => '99999996',
            'jabatan' => 'Sekretaris Jenderal',
            'periode' => $active->name,
            'status' => 'Aktif',
            'tugas_tanggung_jawab' => "Tugas pertama untuk uji.\nTugas kedua untuk uji.",
        ]);

        $this->get(route('profil-dewan.detail', '99999996'))
            ->assertOk()
            ->assertSee('Tugas pertama untuk uji.')
            ->assertSee('Tugas kedua untuk uji.');
    }
}
