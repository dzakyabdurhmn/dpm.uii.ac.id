<?php

namespace Tests\Feature;

use App\Models\DanaTriwulan;
use App\Models\Period;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DistribusiDanaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_admin_can_open_create_and_edit_forms(): void
    {
        $admin = User::query()->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.distribusi-dana.create'))
            ->assertOk();

        $triwulan = DanaTriwulan::query()->create([
            'periode_id' => Period::query()->where('is_active', true)->value('id'),
            'triwulan' => 1,
            'total_dana' => 1_000_000,
            'status' => 'draft',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.distribusi-dana.edit', $triwulan))
            ->assertOk();
    }

    public function test_period_and_triwulan_filters_come_from_published_data(): void
    {
        $current = Period::query()->where('name', '2025/2026')->firstOrFail();
        $previous = Period::query()->where('name', '2024/2025')->firstOrFail();

        DanaTriwulan::query()->create([
            'periode_id' => $current->id,
            'triwulan' => 2,
            'total_dana' => 500_000,
            'status' => 'terbit',
        ]);

        DanaTriwulan::query()->create([
            'periode_id' => $previous->id,
            'triwulan' => 4,
            'total_dana' => 400_000,
            'status' => 'terbit',
        ]);

        // Periode tanpa triwulan terbit tidak boleh muncul sebagai filter.
        $this->get(route('dana.distribusi'))
            ->assertOk()
            ->assertSee('2025/2026')
            ->assertSee('2024/2025')
            ->assertDontSee('2023/2024')
            ->assertSee('Triwulan II')
            ->assertDontSee('Triwulan IV')
            ->assertSee('Menampilkan: Periode 2025/2026 · Triwulan II');

        $this->get(route('dana.distribusi', ['periode' => $previous->id, 'triwulan' => 4]))
            ->assertOk()
            ->assertSee('Menampilkan: Periode 2024/2025 · Triwulan IV')
            ->assertSee('Overview dana Triwulan IV');
    }

    public function test_dana_page_only_shows_three_entry_cards(): void
    {
        $this->get(route('documents.dana'))
            ->assertOk()
            ->assertSee('LPJ')
            ->assertSee('LHA')
            ->assertSee('Distribusi Dana')
            ->assertSee(route('documents.lpj'), false)
            ->assertSee(route('documents.lha'), false)
            ->assertSee(route('dana.distribusi'), false)
            ->assertDontSee('docs-list-item');
    }
}
