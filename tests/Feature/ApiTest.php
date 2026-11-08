<?php

namespace Tests\Feature;

use App\Models\Complaint;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\LegalProduct;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_home_endpoint_returns_aggregated_payload(): void
    {
        $this->getJson('/api/home')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'stats' => ['legal_products', 'documents', 'units', 'posts'],
                    'legal_products' => ['types' => ['pdkm', 'gbhkm', 'pkm', 'pdpm'], 'latest'],
                    'documents' => ['categories', 'latest'],
                    'reports',
                    'posts',
                    'units',
                ],
            ]);
    }

    public function test_settings_endpoint_exposes_site_identity_and_sections(): void
    {
        $response = $this->getJson('/api/settings')
            ->assertOk()
            ->assertJsonPath('data.site.name', 'DPM UII')
            ->assertJsonPath('data.social.instagram', 'https://www.instagram.com/dpmuii/')
            ->assertJsonPath('data.social.linkedin', 'https://www.linkedin.com/company/dewan-permusyawaratan-mahasiswa/')
            ->assertJsonPath('data.social.twitter', 'https://twitter.com/DPM_UII')
            ->assertJsonFragment(['key' => 'sambutan']);

        $this->assertContains('/tentang/sambutan', array_column($response->json('data.sections'), 'url'));
        // Navigasi header statis di frontend, bukan dari database.
        $this->assertSame([], $response->json('data.navigation'));
    }

    public function test_documents_can_be_filtered_by_quarter(): void
    {
        $category = DocumentCategory::query()->firstOrFail();

        Document::query()->create([
            'document_category_id' => $category->id,
            'title' => 'Laporan Triwulan III 2030',
            'slug' => 'laporan-triwulan-iii-2030-api',
            'year' => 2030,
            'quarter' => 3,
            'published_at' => now()->subDay(),
        ]);

        Document::query()->create([
            'document_category_id' => $category->id,
            'title' => 'Laporan Triwulan IV 2030',
            'slug' => 'laporan-triwulan-iv-2030-api',
            'year' => 2030,
            'quarter' => 4,
            'published_at' => now()->subDay(),
        ]);

        $this->getJson('/api/documents?triwulan=3')
            ->assertOk()
            ->assertJsonPath('meta.quarters.3', 'Triwulan III')
            ->assertJsonFragment(['title' => 'Laporan Triwulan III 2030'])
            ->assertJsonMissing(['title' => 'Laporan Triwulan IV 2030']);
    }

    public function test_reports_endpoint_groups_documents_per_quarter(): void
    {
        $category = DocumentCategory::query()->where('slug', 'laporan-keuangan')->firstOrFail();

        Document::query()->create([
            'document_category_id' => $category->id,
            'title' => 'Laporan Keuangan Triwulan II 2031',
            'slug' => 'lk-triwulan-ii-2031-api',
            'year' => 2031,
            'quarter' => 2,
            'published_at' => now()->subDay(),
        ]);

        $response = $this->getJson('/api/documents/reports')->assertOk();

        $year = collect($response->json('data'))->firstWhere('year', 2031);

        $this->assertNotNull($year);
        $this->assertCount(4, $year['quarters']);
        $this->assertSame('Laporan Keuangan Triwulan II 2031', $year['quarters'][1]['documents'][0]['title']);
    }

    public function test_legal_products_grouped_endpoint_requires_a_type(): void
    {
        $this->getJson('/api/legal-products/grouped')->assertStatus(422);

        LegalProduct::query()->create([
            'type' => 'pkm',
            'number' => 2,
            'year' => 2023,
            'title' => 'PKM UII No. 2 Tahun 2023',
            'file_path' => 'uploads/produk-hukum/2023/pkm-2.pdf',
            'is_published' => true,
        ]);

        $this->getJson('/api/legal-products/grouped?type=pkm')
            ->assertOk()
            ->assertJsonPath('data.type', 'pkm')
            ->assertJsonStructure(['data' => ['groups' => [['year', 'total', 'items']]]]);

        $this->getJson('/api/legal-products/types')
            ->assertOk()
            ->assertJsonStructure(['data' => ['pdkm' => ['label', 'numbered', 'total']]]);
    }

    public function test_posts_listing_hides_drafts_and_show_returns_body(): void
    {
        Post::query()->create([
            'title' => 'Berita Terbit',
            'slug' => 'berita-terbit-api',
            'body' => '<p>Konten berita</p>',
            'status' => Post::STATUS_PUBLISHED,
            'published_at' => now()->subHour(),
        ]);

        Post::query()->create([
            'title' => 'Berita Draf',
            'slug' => 'berita-draf-api',
            'body' => '<p>Belum terbit</p>',
            'status' => Post::STATUS_DRAFT,
        ]);

        $this->getJson('/api/posts')
            ->assertOk()
            ->assertJsonFragment(['title' => 'Berita Terbit'])
            ->assertJsonMissing(['title' => 'Berita Draf']);

        $this->getJson('/api/posts/berita-terbit-api')
            ->assertOk()
            ->assertJsonPath('data.body', '<p>Konten berita</p>');

        $this->getJson('/api/posts/berita-draf-api')->assertNotFound();
    }

    public function test_units_are_public(): void
    {
        $this->getJson('/api/units')
            ->assertOk()
            ->assertJsonStructure(['data' => [['id', 'name', 'slug', 'officials']]]);
    }

    public function test_complaint_can_be_submitted_and_tracked(): void
    {
        Storage::fake('uploads');

        $response = $this->postJson('/api/complaints', [
            'name' => 'Mahasiswa UII',
            'email' => 'mahasiswa@uii.ac.id',
            'category' => 'Fasilitas',
            'subject' => 'Kursi ruang baca rusak',
            'message' => 'Kursi di ruang baca lantai dua banyak yang rusak sejak lama.',
            'attachment' => UploadedFile::fake()->create('bukti.pdf', 120, 'application/pdf'),
        ])->assertCreated();

        $ticket = $response->json('data.ticket_number');

        $this->assertNotEmpty($ticket);
        $this->assertStringStartsWith('DPM-', $ticket);

        $complaint = Complaint::query()->where('ticket_number', $ticket)->firstOrFail();
        $this->assertNotNull($complaint->attachment_path);
        Storage::disk('uploads')->assertExists(str_replace('uploads/', '', $complaint->attachment_path));

        $this->getJson('/api/complaints/'.$ticket)
            ->assertOk()
            ->assertJsonPath('data.status', 'baru')
            ->assertJsonPath('data.subject', 'Kursi ruang baca rusak');
    }

    public function test_anonymous_complaint_does_not_store_the_name(): void
    {
        $ticket = $this->postJson('/api/complaints', [
            'is_anonymous' => true,
            'email' => 'anonim@uii.ac.id',
            'subject' => 'Laporan anonim',
            'message' => 'Saya melaporkan hal ini tanpa ingin identitas saya diketahui.',
        ])->assertCreated()->json('data.ticket_number');

        $this->assertNull(Complaint::query()->where('ticket_number', $ticket)->value('name'));
    }

    public function test_complaint_validation_rejects_short_messages_and_executables(): void
    {
        $this->postJson('/api/complaints', [
            'email' => 'bukan-email',
            'subject' => '',
            'message' => 'pendek',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'subject', 'message']);

        $this->postJson('/api/complaints', [
            'name' => 'Pengadu',
            'email' => 'ok@uii.ac.id',
            'subject' => 'Lampiran terlarang',
            'message' => 'Pesan ini cukup panjang untuk lolos validasi minimal.',
            'attachment' => UploadedFile::fake()->create('virus.exe', 10, 'application/x-msdownload'),
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['attachment']);
    }

    public function test_cors_allows_configured_frontend_origin(): void
    {
        $this->withHeader('Origin', 'http://localhost:3000')
            ->getJson('/api/settings')
            ->assertOk()
            ->assertHeader('Access-Control-Allow-Origin', 'http://localhost:3000');
    }
}
