<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Media;
use App\Models\PageContent;
use App\Models\Post;
use App\Models\Setting;
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

    public function test_admin_can_update_the_sambutan_wysiwyg_content(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.page-contents.edit', 'sambutan'))
            ->assertOk()
            ->assertSee('data-rich-editor', false)
            ->assertSee('Identitas Penanda Tangan');

        $this->actingAs($this->admin)
            ->put(route('admin.page-contents.update', 'sambutan'), [
                'body' => '<h2>Salam</h2><p>Parlemen mahasiswa yang aspiratif.</p>',
                'signature_role' => 'Ketua DPM UII',
                'signature_name' => 'Ahmad Fauzan',
                'signature_fakultas' => 'Fakultas Hukum',
                'signature_nim' => '21522045',
            ])
            ->assertRedirect(route('admin.page-contents.edit', 'sambutan'));

        $content = PageContent::query()->where('key', 'sambutan')->firstOrFail();
        $this->assertStringContainsString('aspiratif', $content->body);
        $this->assertSame('Ahmad Fauzan', $content->signature_name);
        $this->assertSame('21522045', $content->signature_nim);

        $this->get(route('about.show', 'sambutan'))
            ->assertOk()
            ->assertSee('aspiratif')
            ->assertSee('Ahmad Fauzan')
            ->assertSee('Fakultas Hukum')
            ->assertSee('NIM 21522045');

        // Section di luar daftar tetap tidak bisa diakses.
        $this->actingAs($this->admin)
            ->put(route('admin.page-contents.update', 'halaman-bebas'), ['body' => '<p>x</p>'])
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

    public function test_document_create_preselects_lpj_and_lha_categories(): void
    {
        $lpj = DocumentCategory::query()->where('slug', 'lpj')->firstOrFail();
        $lha = DocumentCategory::query()->where('slug', 'lha')->firstOrFail();

        $this->actingAs($this->admin)
            ->get(route('admin.documents.index'))
            ->assertOk()
            ->assertSee(route('admin.documents.create', ['kategori' => 'lpj']), false)
            ->assertSee(route('admin.documents.create', ['kategori' => 'lha']), false);

        $this->actingAs($this->admin)
            ->get(route('admin.documents.create', ['kategori' => 'lpj']))
            ->assertOk()
            ->assertSee('value="'.$lpj->id.'" selected', false);

        $this->actingAs($this->admin)
            ->get(route('admin.documents.create', ['kategori' => 'lha']))
            ->assertOk()
            ->assertSee('value="'.$lha->id.'" selected', false);
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

    public function test_admin_can_update_site_contact_settings(): void
    {
        $this->actingAs($this->admin)
            ->put(route('admin.settings.update'), [
                'contact_email' => 'dpm@uii.ac.id',
                'contact_phone' => '0274-898444',
            ])
            ->assertRedirect(route('admin.settings.edit'));

        $this->assertSame('dpm@uii.ac.id', Setting::get('contact_email'));
        $this->assertSame('0274-898444', Setting::get('contact_phone'));
    }
}
