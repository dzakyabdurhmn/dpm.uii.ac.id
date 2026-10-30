<?php

namespace Tests\Feature;

use App\Models\LegalProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LegalProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_single_documents_are_listed_without_years(): void
    {
        $this->get(route('legal-products.index'))
            ->assertOk()
            ->assertSee('PDKM')
            ->assertSee('GBHKM')
            ->assertSee('Dokumen tunggal');
    }

    public function test_numbered_regulations_are_grouped_by_year(): void
    {
        LegalProduct::query()->create([
            'type' => 'pkm',
            'number' => 3,
            'year' => 2018,
            'title' => 'Tentang Pedoman Keanggotaan KM UII',
            'is_published' => true,
        ]);

        $this->get(route('legal-products.index'))
            ->assertOk()
            ->assertSee('Tahun 2018')
            ->assertSee('PKM UII No. 3 Tahun 2018')
            ->assertSee('Tentang Pedoman Keanggotaan KM UII');
    }

    public function test_year_filtering_shows_selected_year(): void
    {
        $this->get(route('legal-products.index', ['tahun' => 2024]))
            ->assertOk()
            ->assertSee('2024')
            ->assertSee('Peraturan');
    }

    public function test_unpublished_regulations_are_hidden(): void
    {
        LegalProduct::query()->create([
            'type' => 'pdpm',
            'number' => 9,
            'year' => 2024,
            'title' => 'Tentang Sesuatu yang Belum Terbit',
            'is_published' => false,
        ]);

        $this->get(route('legal-products.index'))
            ->assertOk()
            ->assertDontSee('Tentang Sesuatu yang Belum Terbit');
    }

    public function test_download_redirects_to_the_uploaded_file_and_counts(): void
    {
        $product = LegalProduct::query()->create([
            'type' => 'pkm',
            'number' => 4,
            'year' => 2019,
            'title' => 'Tentang Produksi Jas Almamater',
            'file_path' => 'uploads/produk-hukum/2019/jas.pdf',
            'is_published' => true,
        ]);

        $this->get(route('legal-products.download', $product))
            ->assertRedirect(asset('uploads/produk-hukum/2019/jas.pdf'));

        $this->assertSame(1, $product->fresh()->downloads);
    }

    public function test_legal_product_requires_an_uploaded_file(): void
    {
        $admin = User::query()->firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.legal-products.store'), [
                'type' => 'pdkm',
                'title' => 'Peraturan Dasar KM UII',
                'external_url' => 'https://drive.google.com/file/d/abc/view',
                'is_published' => '1',
            ])
            ->assertSessionHasErrors('file');
    }

    public function test_numbered_type_requires_number_and_year(): void
    {
        $admin = User::query()->firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.legal-products.store'), [
                'type' => 'pkm',
                'title' => 'Tentang Sesuatu',
                'is_published' => '1',
            ])
            ->assertSessionHasErrors(['number', 'year']);
    }

    public function test_single_type_ignores_number_and_year(): void
    {
        Storage::fake('uploads');
        $admin = User::query()->firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.legal-products.store'), [
                'type' => 'pdkm',
                'number' => 7,
                'year' => 2024,
                'title' => 'Peraturan Dasar KM UII (Revisi)',
                'file' => UploadedFile::fake()->create('pdkm.pdf', 90, 'application/pdf'),
                'is_published' => '1',
            ])
            ->assertRedirect();

        $product = LegalProduct::query()->where('title', 'Peraturan Dasar KM UII (Revisi)')->firstOrFail();

        $this->assertNull($product->number);
        $this->assertNull($product->year);
        $this->assertStringStartsWith('uploads/produk-hukum/', $product->file_path);
    }

    public function test_array_query_parameters_do_not_break_the_listings(): void
    {
        // Frontends sometimes repeat a filter key (?tahun=2024&tahun=2023) or
        // send ?tahun[]=2024, which PHP parses as an array.
        $this->get('/produk-hukum?tahun[]=2018&jenis[]=pkm')
            ->assertOk()
            ->assertSee('Produk Hukum');

        $this->actingAs(User::query()->firstOrFail())
            ->get('/admin/legal-products?jenis[]=pkm&q[]=dana')
            ->assertOk()
            ->assertSee('Produk Hukum');
    }

    public function test_amendment_must_target_the_same_type(): void
    {
        $admin = User::query()->firstOrFail();
        $pkm = LegalProduct::query()->create([
            'type' => 'pkm',
            'number' => 1,
            'year' => 2024,
            'title' => 'PKM UII No. 1 Tahun 2024',
            'file_path' => 'uploads/produk-hukum/2024/pkm-1.pdf',
            'is_published' => true,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.legal-products.store'), [
                'type' => 'pdpm',
                'number' => 2,
                'year' => 2025,
                'title' => 'Tentang Perubahan',
                'amends_id' => $pkm->id,
                'file' => UploadedFile::fake()->create('perubahan.pdf', 40, 'application/pdf'),
                'is_published' => '1',
            ])
            ->assertSessionHasErrors('amends_id');
    }
}
