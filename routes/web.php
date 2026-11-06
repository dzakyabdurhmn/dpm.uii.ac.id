<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentCategoryController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\Admin\LegalProductController as AdminLegalProductController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OfficialController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UnitController as AdminUnitController;
use App\Http\Controllers\Site\AboutController;
use App\Http\Controllers\Site\BioLinkController;
use App\Http\Controllers\Site\DocumentController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\HumasController;
use App\Http\Controllers\Site\LegalProductController;
use App\Http\Controllers\Site\NewsController;
use App\Http\Controllers\Site\UnitController;
use App\Models\LegalProduct;
use App\Models\SiteContent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public site
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/produk-hukum', [LegalProductController::class, 'index'])->name('legal-products.index');
Route::get('/produk-hukum/{type}', [LegalProductController::class, 'type'])->name('legal-products.type')
    ->whereIn('type', array_keys(LegalProduct::TYPES));
Route::get('/produk-hukum/{legalProduct:slug}/unduh', [LegalProductController::class, 'download'])->name('legal-products.download');

Route::get('/dokumen', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/dokumen/{document:slug}/unduh', [DocumentController::class, 'download'])->name('documents.download');

Route::get('/laporan-kinerja', [DocumentController::class, 'reports'])->name('documents.reports');
Route::get('/keputusan', [DocumentController::class, 'decisions'])->name('documents.decisions');

Route::get('/dokumen/kategori/{category:slug}', [DocumentController::class, 'category'])->name('documents.category');
Route::get('/dana', [DocumentController::class, 'dana'])->name('documents.dana');
Route::get('/dana/{category:slug}', [DocumentController::class, 'danaCategory'])->name('documents.dana.category');

Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita-kegiatan', [NewsController::class, 'activities'])->name('news.activities');
Route::get('/pengumuman', [NewsController::class, 'announcements'])->name('news.announcements');
Route::get('/sosialisasi', [NewsController::class, 'socialization'])->name('news.socialization');
Route::get('/berita/kategori/{postCategory:slug}', [NewsController::class, 'category'])->name('news.category');
Route::get('/berita/{post:slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/tentang/{section}', [AboutController::class, 'show'])
    ->whereIn('section', SiteContent::keys())
    ->name('about.show');

Route::get('/alat-kelengkapan', [UnitController::class, 'index'])->name('units.index');
Route::get('/unit/{unit:slug}', [UnitController::class, 'show'])->name('units.show');

Route::get('/bio-link', [BioLinkController::class, 'index'])->name('bio-link');

Route::get('/humas/download', [HumasController::class, 'download'])->name('humas.download');
Route::get('/humas/download/{file}', [HumasController::class, 'downloadFile'])->name('publikasi.download.file');
Route::get('/humas/sosialisasi', [HumasController::class, 'sosialisasi'])->name('humas.sosialisasi');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store'])
            ->middleware('throttle:10,1')
            ->name('login.store');
    });

    Route::post('logout', [LoginController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('posts', PostController::class)->except(['show']);
        Route::resource('documents', AdminDocumentController::class)->except(['show']);
        Route::resource('legal-products', AdminLegalProductController::class)->except(['show']);

        Route::get('konten', [ContentController::class, 'index'])->name('contents.index');
        Route::get('konten/{section}/edit', [ContentController::class, 'edit'])->name('contents.edit');
        Route::put('konten/{section}', [ContentController::class, 'update'])->name('contents.update');

        // Alat kelengkapan bersifat tetap: hanya ubah, tanpa tambah/hapus.
        Route::resource('units', AdminUnitController::class)->only(['index', 'edit', 'update']);
        Route::post('units/{unit}/fungsionaris', [OfficialController::class, 'store'])->name('units.officials.store');
        Route::put('units/{unit}/fungsionaris/{official}', [OfficialController::class, 'update'])->name('units.officials.update');
        Route::delete('units/{unit}/fungsionaris/{official}', [OfficialController::class, 'destroy'])->name('units.officials.destroy');

        Route::resource('kategori-dokumen', DocumentCategoryController::class)
            ->except(['show'])
            ->parameters(['kategori-dokumen' => 'documentCategory'])
            ->names('document-categories');

        Route::resource('kategori-berita', PostCategoryController::class)
            ->except(['show'])
            ->parameters(['kategori-berita' => 'postCategory'])
            ->names('post-categories');

        Route::resource('menu', MenuController::class)
            ->except(['show'])
            ->parameters(['menu' => 'menuItem'])
            ->names('menu');

        Route::post('periode/{period}/aktifkan', [PeriodController::class, 'activate'])->name('periods.activate');
        Route::resource('periode', PeriodController::class)
            ->except(['show'])
            ->parameters(['periode' => 'period'])
            ->names('periods');

        Route::get('media', [MediaController::class, 'index'])->name('media.index');
        Route::post('media', [MediaController::class, 'store'])->name('media.store');
        Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
