<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistribusiDanaController as AdminDistribusiDanaController;
use App\Http\Controllers\Admin\DocumentCategoryController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\Admin\LegalProductController as AdminLegalProductController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\OfficialController;
use App\Http\Controllers\Admin\PageContentController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\PimpinanDewanController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UnitController as AdminUnitController;
use App\Http\Controllers\LaporanKinerjaController;
use App\Http\Controllers\Site\AboutController;
use App\Http\Controllers\Site\BioLinkController;
use App\Http\Controllers\Site\DistribusiDanaController;
use App\Http\Controllers\Site\DocumentController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\HumasController;
use App\Http\Controllers\Site\LegalProductController;
use App\Http\Controllers\Site\NewsController;
use App\Http\Controllers\Site\ProfilDewanController;
use App\Http\Controllers\Site\UnitController;
use App\Models\LegalProduct;
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

Route::get('/dana', [DocumentController::class, 'dana'])->name('documents.dana');
Route::get('/dana/lpj', [DocumentController::class, 'lpj'])->name('documents.lpj');
Route::get('/dana/lha', [DocumentController::class, 'lha'])->name('documents.lha');
Route::get('/dana/distribusi-dana', [DistribusiDanaController::class, 'index'])->name('dana.distribusi');
Route::get('/dana/{category:slug}', [DocumentController::class, 'danaCategory'])->name('documents.dana.category');

Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita-kegiatan', [NewsController::class, 'activities'])->name('news.activities');
Route::get('/pengumuman', [NewsController::class, 'announcements'])->name('news.announcements');
Route::get('/sosialisasi', [NewsController::class, 'socialization'])->name('news.socialization');
Route::get('/berita/{post:slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/tentang/{section}', [AboutController::class, 'show'])
    ->whereIn('section', ['sambutan', 'sejarah', 'visi-misi', 'struktur', 'kedudukan-tugas-wewenang'])
    ->name('about.show');

Route::get('/laporan-kinerja', [LaporanKinerjaController::class, 'index'])->name('laporan-kinerja.index');

Route::get('/profil-dewan', [ProfilDewanController::class, 'index'])->name('profil-dewan.index');
Route::get('/profil-dewan/{nim}', [ProfilDewanController::class, 'show'])->name('profil-dewan.detail');

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

        // Alat kelengkapan bersifat tetap: hanya ubah nama tidak diperbolehkan, hanya anggota.
        Route::resource('units', AdminUnitController::class)->only(['index', 'edit', 'update']);
        Route::post('units/{unit}/fungsionaris', [OfficialController::class, 'store'])->name('units.officials.store');
        Route::put('units/{unit}/fungsionaris/{official}', [OfficialController::class, 'update'])->name('units.officials.update');
        Route::delete('units/{unit}/fungsionaris/{official}', [OfficialController::class, 'destroy'])->name('units.officials.destroy');

        Route::resource('kategori-dokumen', DocumentCategoryController::class)
            ->except(['show'])
            ->parameters(['kategori-dokumen' => 'documentCategory'])
            ->names('document-categories');

        Route::resource('pimpinan-dewan', PimpinanDewanController::class)
            ->except(['show'])
            ->names('pimpinan-dewan');

        Route::get('pimpinan-dewan/{pimpinan}/tugas', [PimpinanDewanController::class, 'tugas'])
            ->name('pimpinan-dewan.tugas');
        Route::post('pimpinan-dewan/{pimpinan}/tugas', [PimpinanDewanController::class, 'tugasStore'])
            ->name('pimpinan-dewan.tugas.store');
        Route::put('pimpinan-dewan/{pimpinan}/tugas/{tugas}', [PimpinanDewanController::class, 'tugasUpdate'])
            ->name('pimpinan-dewan.tugas.update');
        Route::delete('pimpinan-dewan/{pimpinan}/tugas/{tugas}', [PimpinanDewanController::class, 'tugasDestroy'])
            ->name('pimpinan-dewan.tugas.destroy');

        Route::resource('distribusi-dana', AdminDistribusiDanaController::class)
            ->except(['show'])
            ->names('distribusi-dana');

        Route::resource('aspirasi', ComplaintController::class)->only(['index', 'edit', 'update', 'destroy'])
            ->names('aspirasi');

        Route::resource('page-contents', PageContentController::class)
            ->only(['index', 'edit', 'update'])
            ->names('page-contents')
            ->parameters(['page-contents' => 'section']);

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
