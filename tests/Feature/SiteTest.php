<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_landing_page_renders_site_identity(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('DPM UII')
            ->assertSee('Produk Hukum');
    }

    public function test_fixed_content_sections_are_public(): void
    {
        $this->get(route('about.show', 'visi-misi'))
            ->assertOk()
            ->assertSee('Visi');

        $this->get(route('about.show', 'kedudukan-tugas-wewenang'))
            ->assertOk()
            ->assertSee('Wewenang');

        $this->get(route('about.show', 'struktur'))
            ->assertOk()
            ->assertSee('Struktur Lembaga KM UII')
            ->assertSee('Kelompok Lembaga');

        // Tidak ada halaman bebas: seksi tak dikenal = 404.
        $this->get('/tentang/halaman-bebas')->assertNotFound();
    }

    public function test_berita_lists_only_published_posts(): void
    {
        $published = Post::query()->create([
            'title' => 'Sosialisasi Produk Hukum',
            'slug' => 'sosialisasi-produk-hukum',
            'body' => '<p>Isi</p>',
            'status' => Post::STATUS_PUBLISHED,
            'published_at' => now()->subDay(),
        ]);

        $this->get(route('news.index'))->assertOk()->assertSee($published->title);

        $published->update(['status' => Post::STATUS_DRAFT]);

        $this->get(route('news.index'))->assertOk()->assertDontSee($published->title);
        $this->get(route('news.show', $published))->assertNotFound();
    }

    public function test_document_download_counts_and_redirects(): void
    {
        $category = DocumentCategory::query()->firstOrFail();

        $document = Document::query()->create([
            'document_category_id' => $category->id,
            'title' => 'Laporan Keuangan Triwulan I',
            'external_url' => 'https://drive.google.com/file/d/example/view',
            'year' => 2026,
            'quarter' => 1,
            'published_at' => now()->subDay(),
        ]);

        $this->get(route('documents.index'))->assertOk()->assertSee('Laporan Keuangan Triwulan I');

        $this->get(route('documents.download', $document))
            ->assertRedirect('https://drive.google.com/file/d/example/view');

        $this->assertSame(1, $document->fresh()->downloads);
    }

    public function test_bio_link_page_renders_quick_links(): void
    {
        $this->get(route('bio-link'))
            ->assertOk()
            ->assertSee('@dpmuii')
            ->assertSee('Produk Hukum')
            ->assertSee('Surat Keputusan');
    }

    public function test_humas_download_page_lists_and_serves_internal_files(): void
    {
        $this->get(route('humas.download'))
            ->assertOk()
            ->assertSee('UII Font')
            ->assertSee('Template Surat');

        $this->get(route('publikasi.download.file', ['file' => 'UII Font.ttf']))
            ->assertOk();

        // Hanya file yang ada di daftar putih yang boleh diunduh.
        $this->get(route('publikasi.download.file', ['file' => 'rahasia.pdf']))
            ->assertNotFound();
    }

    public function test_humas_sosialisasi_page_explains_regulations(): void
    {
        $this->get(route('humas.sosialisasi'))
            ->assertOk()
            ->assertSee('PDKM')
            ->assertSee('GBHKM')
            ->assertSee('PKM')
            ->assertSee('PDPM');
    }

    public function test_documents_support_quarter_filtering(): void
    {
        $category = DocumentCategory::query()->firstOrFail();

        Document::query()->create([
            'document_category_id' => $category->id,
            'title' => 'Laporan Triwulan II',
            'external_url' => 'https://example.com/tw2.pdf',
            'year' => 2026,
            'quarter' => 2,
            'published_at' => now()->subDay(),
        ]);

        $this->get(route('documents.index', ['triwulan' => 2]))
            ->assertOk()
            ->assertSee('Laporan Triwulan II');

        $this->get(route('documents.index', ['triwulan' => 3]))
            ->assertOk()
            ->assertDontSee('Laporan Triwulan II');
    }
}
