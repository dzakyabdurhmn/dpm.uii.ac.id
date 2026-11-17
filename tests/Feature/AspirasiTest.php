<?php

namespace Tests\Feature;

use App\Models\Complaint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AspirasiTest extends TestCase
{
    use RefreshDatabase;

    public function test_form_aspirasi_menyimpan_data_dengan_email(): void
    {
        $response = $this->postJson(route('aspirasi.store'), [
            'nama' => 'Ahmad Fauzan',
            'kontak' => 'ahmad@students.uii.ac.id',
            'pesan' => 'Mohon perbaikan jadwal kuliah semester ini agar tidak bentrok.',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.status', 'baru')
            ->assertJsonStructure(['data' => ['ticket_number', 'status_label', 'created_at']]);

        $complaint = Complaint::query()->firstOrFail();

        $this->assertSame('Ahmad Fauzan', $complaint->name);
        $this->assertSame('ahmad@students.uii.ac.id', $complaint->email);
        $this->assertNull($complaint->student_id);
        $this->assertSame('baru', $complaint->status);
        $this->assertSame($response->json('data.ticket_number'), $complaint->ticket_number);
        $this->assertSame(
            'Mohon perbaikan jadwal kuliah semester ini agar tidak bentrok.',
            $complaint->message,
        );
    }

    public function test_form_aspirasi_menyimpan_nim_tanpa_email(): void
    {
        $this->postJson(route('aspirasi.store'), [
            'nama' => 'Siti Rahma',
            'kontak' => '23521001',
            'pesan' => 'Tolong tinjau ulang kebijakan uang kuliah tunggal untuk angkatan 2023.',
        ])->assertCreated();

        $complaint = Complaint::query()->firstOrFail();

        $this->assertNull($complaint->email);
        $this->assertSame('23521001', $complaint->student_id);
    }

    public function test_isi_aspirasi_terlalu_pendek_ditolak(): void
    {
        $this->postJson(route('aspirasi.store'), [
            'nama' => 'Budi',
            'kontak' => 'budi@students.uii.ac.id',
            'pesan' => 'Kurang jelas',
        ])->assertStatus(422)->assertJsonValidationErrors('pesan');

        $this->assertSame(0, Complaint::query()->count());
    }

    public function test_field_wajib_divalidasi(): void
    {
        $this->postJson(route('aspirasi.store'), [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['nama', 'kontak', 'pesan']);
    }
}
