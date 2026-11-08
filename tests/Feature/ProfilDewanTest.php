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
