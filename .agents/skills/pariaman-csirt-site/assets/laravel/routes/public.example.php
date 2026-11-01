<?php

// Tempel ke routes/web.php (lihat references/SETUP.md, bagian 10.1). Semua rute publik hanya GET: situs tidak menerima input.
//
// Daftarkan juga di App\Providers\AppServiceProvider::boot():
//
//   use App\View\Composers\SiteComposer;
//   use Illuminate\Support\Facades\View;
//
//   View::composer('layouts.app', SiteComposer::class);
//
// Urutan penting: rute {slug} untuk halaman dinamis harus PALING AKHIR, dan slug tetap harus ada di Page::RESERVED_SLUGS.

use App\Http\Controllers\AdvisoryController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\SecurityTxtController;
use App\Http\Controllers\ServiceController;
use App\Http\Middleware\PublicSecurityHeaders;
use Illuminate\Support\Facades\Route;

Route::get('/.well-known/security.txt', SecurityTxtController::class)->name('security.txt');

Route::middleware(PublicSecurityHeaders::class)->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');

    Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/agen-siber', [AgentController::class, 'index'])->name('agents.index');
    Route::get('/dokumen', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/agenda', [EventController::class, 'index'])->name('events.index');

    Route::get('/advisori', [AdvisoryController::class, 'index'])->name('advisories.index');
    Route::get('/advisori/{slug}', [AdvisoryController::class, 'show'])->name('advisories.show');

    Route::get('/{path}', [PostController::class, 'index'])->where('path', 'berita|edukasi')->name('posts.index');
    Route::get('/{path}/{slug}', [PostController::class, 'show'])->where('path', 'berita|edukasi')->name('posts.show');

    // Pratinjau untuk staf (404 bagi selain staf). Tombol "Pratinjau" di Filament mengarah ke sini.
    Route::get('/pratinjau/halaman/{page}', [PreviewController::class, 'page'])->name('preview.page');
    Route::get('/pratinjau/pos/{post}', [PreviewController::class, 'post'])->name('preview.post');
    Route::get('/pratinjau/advisori/{advisory}', [PreviewController::class, 'advisory'])->name('preview.advisory');

    // PALING AKHIR: halaman dinamis dari panel admin.
    Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('page.show');
});
