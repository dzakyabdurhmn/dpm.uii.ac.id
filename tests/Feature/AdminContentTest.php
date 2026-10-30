<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Media;
use App\Models\Post;
use App\Models\Setting;
use App\Models\SiteContent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminContentTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->admin = User::query()->firstOrFail();
    }

    public function test_admin_can_create_a_post(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.posts.store'), [
                'title' => 'Rapat Koordinasi Legislasi',
                'excerpt' => 'Ringkasan rapat koordinasi.',
                'body' => '<p>Isi berita.</p>',
                'status' => Post::STATUS_PUBLISHED,
            ])
            ->assertRedirect();

        $post = Post::query()->where('title', 'Rapat Koordinasi Legislasi')->firstOrFail();

        $this->assertSame('rapat-koordinasi-legislasi', $post->slug);
        $this->assertNotNull($post->published_at);
        $this->get(route('news.show', $post))->assertOk()->assertSee('Rapat Koordinasi Legislasi');
    }

    public function test_post_requires_a_title(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.posts.store'), ['status' => Post::STATUS_DRAFT])
            ->assertSessionHasErrors('title');
    }

    public function test_admin_can_update_a_fixed_content_section(): void
    {
        $this->actingAs($this->admin)
            ->put(route('admin.contents.update', 'visi-misi'), [
                'body' => '<h2>Visi</h2><p>Parlemen mahasiswa yang aspiratif.</p>',
            ])
            ->assertRedirect();

        $content = SiteContent::query()->where('key', 'visi-misi')->firstOrFail();
        $this->assertStringContainsString('aspiratif', $content->body);

        $this->get(route('about.show', 'visi-misi'))
            ->assertOk()
            ->assertSee('aspiratif');

        // Section di luar daftar tetap tidak bisa diakses.
        $this->actingAs($this->admin)
            ->put(route('admin.contents.update', 'halaman-bebas'), ['body' => '<p>x</p>'])
            ->assertNotFound();
    }

    public function test_admin_can_upload_a_document(): void
    {
        Storage::fake('uploads');

        $category = DocumentCategory::query()->firstOrFail();

        $this->actingAs($this->admin)
            ->post(route('admin.documents.store'), [
                'document_category_id' => $category->id,
                'title' => 'Laporan Keuangan Triwulan III',
                'year' => 2026,
                'quarter' => 3,
                'published_at' => now()->format('Y-m-d H:i:s'),
                'file' => UploadedFile::fake()->create('laporan-tw3.pdf', 120, 'application/pdf'),
            ])
            ->assertRedirect();

        $document = Document::query()->where('title', 'Laporan Keuangan Triwulan III')->firstOrFail();

        $this->assertStringStartsWith('uploads/documents/', $document->file_path);
        Storage::disk('uploads')->assertExists(str_replace('uploads/', '', $document->file_path));
        $this->assertSame('PDF', $document->extension);
    }

    public function test_document_requires_a_file_or_external_link(): void
    {
        $category = DocumentCategory::query()->firstOrFail();

        $this->actingAs($this->admin)
            ->post(route('admin.documents.store'), [
                'document_category_id' => $category->id,
                'title' => 'Dokumen Tanpa Berkas',
            ])
            ->assertSessionHasErrors('file');
    }

    public function test_admin_can_upload_media_and_delete_it(): void
    {
        Storage::fake('uploads');

        $this->actingAs($this->admin)
            ->post(route('admin.media.store'), [
                'file' => UploadedFile::fake()->image('foto-kegiatan.jpg', 800, 600),
            ])
            ->assertRedirect();

        $media = Media::query()->firstOrFail();

        $this->assertTrue($media->isImage());
        Storage::disk('uploads')->assertExists(str_replace('uploads/', '', $media->file_path));

        $this->actingAs($this->admin)
            ->delete(route('admin.media.destroy', $media))
            ->assertRedirect();

        $this->assertDatabaseCount('media', 0);
        Storage::disk('uploads')->assertMissing(str_replace('uploads/', '', $media->file_path));
    }

    public function test_media_rejects_unsupported_file_types(): void
    {
        Storage::fake('uploads');

        $this->actingAs($this->admin)
            ->post(route('admin.media.store'), [
                'file' => UploadedFile::fake()->create('script.exe', 10),
            ])
            ->assertSessionHasErrors('file');
    }

    public function test_admin_can_update_site_settings(): void
    {
        $this->actingAs($this->admin)
            ->put(route('admin.settings.update'), [
                'site_name' => 'DPM UII Baru',
                'site_tagline' => 'Dewan Permusyawaratan Mahasiswa',
                'contact_email' => 'dpm@uii.ac.id',
            ])
            ->assertRedirect(route('admin.settings.edit'));

        $this->assertSame('DPM UII Baru', Setting::get('site_name'));
        $this->get('/')->assertOk()->assertSee('DPM UII Baru');
    }
}
