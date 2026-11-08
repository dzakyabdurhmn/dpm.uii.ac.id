<?php

namespace Tests\Feature;

use App\Models\Official;
use App\Models\OrganizationalUnit;
use App\Models\Period;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UnitMembersTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->admin = User::query()->firstOrFail();
    }

    public function test_alat_kelengkapan_cannot_be_created_or_deleted(): void
    {
        $unit = OrganizationalUnit::query()->firstOrFail();

        $this->actingAs($this->admin)
            ->post('/admin/units', ['name' => 'Unit Baru'])
            ->assertStatus(405);

        $this->actingAs($this->admin)
            ->delete('/admin/units/'.$unit->id)
            ->assertStatus(405);

        $this->assertDatabaseHas('organizational_units', ['id' => $unit->id]);
    }

    public function test_admin_can_update_unit_description(): void
    {
        $unit = OrganizationalUnit::query()->where('slug', 'mentari')->firstOrFail();

        $this->actingAs($this->admin)
            ->put(route('admin.units.update', $unit), [
                'name' => $unit->name,
                'abbreviation' => $unit->abbreviation,
                'type' => $unit->type,
                'description' => 'Mentari adalah badan media dan kesekretariatan DPM UII.',
                'sort_order' => $unit->sort_order,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.units.edit', $unit));

        $this->assertSame(
            'Mentari adalah badan media dan kesekretariatan DPM UII.',
            $unit->refresh()->description,
        );
    }

    public function test_admin_can_add_a_member_with_photo_description_and_period(): void
    {
        Storage::fake('uploads');

        $unit = OrganizationalUnit::query()->where('slug', 'mentari')->firstOrFail();
        $period = Period::query()->where('is_active', true)->firstOrFail();

        $this->actingAs($this->admin)
            ->post(route('admin.units.officials.store', $unit), [
                'name' => 'Nadia Putri',
                'description' => 'Fakultas Hukum / Ilmu Hukum',
                'period_id' => $period->id,
                'sort_order' => 1,
                'is_active' => true,
                'photo' => UploadedFile::fake()->image('nadia.jpg', 400, 500),
            ])
            ->assertRedirect(route('admin.units.edit', $unit));

        $member = Official::query()->where('name', 'Nadia Putri')->firstOrFail();

        $this->assertSame('Fakultas Hukum / Ilmu Hukum', $member->description);
        $this->assertSame($period->id, $member->period_id);
        $this->assertNull($member->position);
        $this->assertNotNull($member->photo_path);
        Storage::disk('uploads')->assertExists(str_replace('uploads/', '', $member->photo_path));
    }

    public function test_unit_page_lists_members_grouped_by_period(): void
    {
        $unit = OrganizationalUnit::query()->where('slug', 'mentari')->firstOrFail();
        $current = Period::query()->where('is_active', true)->firstOrFail();
        $previous = Period::query()->where('is_active', false)->orderByDesc('name')->firstOrFail();

        Official::query()->create([
            'organizational_unit_id' => $unit->id,
            'period_id' => $current->id,
            'name' => 'Anggota Terkini',
            'description' => 'Fakultas Teknik / Informatika',
        ]);

        Official::query()->create([
            'organizational_unit_id' => $unit->id,
            'period_id' => $previous->id,
            'name' => 'Anggota Lama',
            'description' => 'Fakultas Ekonomi / Manajemen',
        ]);

        $this->get(route('units.show', $unit))
            ->assertOk()
            ->assertSee('Anggota')
            ->assertSee('Periode '.$current->name)
            ->assertSee('Periode '.$previous->name)
            ->assertSee('Anggota Terkini')
            // Deskripsi ikut ke dataset JSON; @json meng-escape garis miring.
            ->assertSee('Fakultas Teknik \/ Informatika', false)
            ->assertSee('Anggota Lama');
    }

    public function test_unit_page_puts_the_kepala_in_the_lead_section(): void
    {
        $unit = OrganizationalUnit::query()->where('slug', 'mentari')->firstOrFail();
        $period = Period::query()->where('is_active', true)->firstOrFail();

        Official::query()->create([
            'organizational_unit_id' => $unit->id,
            'period_id' => $period->id,
            'name' => 'Kepala Uji',
            'position' => 'Kepala MENTARI',
            'nim' => '24215039',
            'sort_order' => 1,
        ]);

        Official::query()->create([
            'organizational_unit_id' => $unit->id,
            'period_id' => $period->id,
            'name' => 'Staf Uji',
            'position' => 'Staf Media dan Inventaris',
            'nim' => '25215042',
            'sort_order' => 2,
        ]);

        $this->get(route('units.show', $unit))
            ->assertOk()
            ->assertSee('"lead":{"name":"Kepala Uji"', false)
            ->assertSee('"members":[{"name":"Staf Uji"', false);
    }
}
