<?php

use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\LegalProductController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SiteController;
use App\Http\Controllers\Api\UnitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API (consumed by the separate frontend)
|--------------------------------------------------------------------------
| Read-only endpoints for published content, plus complaint submission.
| All responses are JSON with a top-level "data" key; paginated endpoints
| also include "links" and "meta". Route names are prefixed with "api."
| so they never collide with the Blade site's route names.
*/

Route::name('api.')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('settings', [SiteController::class, 'settings'])->name('settings');

    Route::get('legal-products', [LegalProductController::class, 'index'])->name('legal-products.index');
    Route::get('legal-products/types', [LegalProductController::class, 'types'])->name('legal-products.types');
    Route::get('legal-products/grouped', [LegalProductController::class, 'grouped'])->name('legal-products.grouped');

    Route::get('documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('documents/categories', [DocumentController::class, 'categories'])->name('documents.categories');
    Route::get('documents/reports', [DocumentController::class, 'reports'])->name('documents.reports');

    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

    Route::get('units', [UnitController::class, 'index'])->name('units.index');
    Route::get('units/{unit:slug}', [UnitController::class, 'show'])->name('units.show');

    Route::post('complaints', [ComplaintController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('complaints.store');

    Route::get('complaints/{ticket}', [ComplaintController::class, 'show'])
        ->middleware('throttle:30,1')
        ->name('complaints.show');
});
