<?php

use App\Enums\Severity;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed initial structure
    $this->artisan('db:seed', ['--class' => 'SiteSeeder'])->assertSuccessful();
});

it('renders services catalog page with grouped services and no forms', function () {
    $response = $this->get('/layanan')->assertOk()->assertViewIs('services.index');

    $html = $response->getContent();
    expect($html)->not->toContain('<form')
        ->toContain('Katalog Layanan Keamanan Siber')
        ->toContain('Penanganan Insiden Siber');
});

it('renders cyber agents directory and allows OPD filtering without write forms', function () {
    $response = $this->get('/agen-siber')->assertOk()->assertViewIs('agents.index');
    expect($response->getContent())->not->toContain('<form')
        ->toContain('Daftar Agen Siber OPD')
        ->toContain('Dinas Komunikasi dan Informatika');

    $filtered = $this->get('/agen-siber?opd=Badan+Pengelolaan+Keuangan+dan+Pendapatan+Daerah')
        ->assertOk()
        ->assertViewIs('agents.index');

    expect($filtered->getContent())->toContain('Badan Pengelolaan Keuangan dan Pendapatan Daerah');
});

it('renders official documents and RFC-2350 page with proper categories', function () {
    $response = $this->get('/dokumen')->assertOk()->assertViewIs('documents.index');

    $html = $response->getContent();
    expect($html)->not->toContain('<form')
        ->toContain('Dokumen Resmi & RFC-2350')
        ->toContain('Deskripsi CSIRT Pemerintah Kota Pariaman (RFC-2350)');
});

it('renders agenda and events page with upcoming and past sections', function () {
    $response = $this->get('/agenda')->assertOk()->assertViewIs('events.index');

    $html = $response->getContent();
    expect($html)->not->toContain('<form')
        ->toContain('Agenda & Kegiatan Keamanan Siber')
        ->toContain('Bimbingan Teknis Kesiapsiagaan Tanggap Insiden Siber OPD');
});

it('renders advisories list and details with severity badges', function () {
    $list = $this->get('/advisori')->assertOk()->assertViewIs('advisories.index');
    expect($list->getContent())->not->toContain('<form')
        ->toContain('Advisori Keamanan Siber')
        ->toContain('Peringatan Dini Kerentanan Kritis Remote Code Execution');

    // Filter severity
    $filterHigh = $this->get('/advisori?tingkat=high')->assertOk();
    expect($filterHigh->getContent())->toContain('Peringatan Dini Kerentanan Kritis');

    // Detail view
    $detail = $this->get('/advisori/peringatan-dini-kerentanan-kritis-rce-server')
        ->assertOk()
        ->assertViewIs('advisories.show');

    expect($detail->getContent())->not->toContain('<form')
        ->toContain('Langkah Mitigasi & Rekomendasi Tindakan')
        ->toContain('Sistem & Lingkungan Terdampak');
});

it('renders news and education index and detail views', function () {
    // News index
    $newsList = $this->get('/berita')->assertOk()->assertViewIs('posts.index');
    expect($newsList->getContent())->not->toContain('<form')
        ->toContain('Berita');

    // News detail
    $newsDetail = $this->get('/berita/penguatan-kesiapsiagaan-tanggap-insiden-pemerintah-kota-pariaman')
        ->assertOk()
        ->assertViewIs('posts.show');
    expect($newsDetail->getContent())->not->toContain('<form')
        ->toContain('Penguatan Kesiapsiagaan Tanggap Insiden');

    // Education index
    $eduList = $this->get('/edukasi')->assertOk()->assertViewIs('posts.index');
    expect($eduList->getContent())->not->toContain('<form')
        ->toContain('Edukasi');

    // Education detail
    $eduDetail = $this->get('/edukasi/mengenal-rekayasa-sosial-dan-langkah-pencegahannya')
        ->assertOk()
        ->assertViewIs('posts.show');
    expect($eduDetail->getContent())->not->toContain('<form')
        ->toContain('Mengenal Rekayasa Sosial');
});

it('renders profile, reporting channels, and contact pages from CMS pages', function () {
    // Profile
    $profil = $this->get('/profil')->assertOk()->assertViewIs('pages.show');
    expect($profil->getContent())->toContain('Profil CSIRT Kota Pariaman');

    // Saluran Pelaporan
    $saluran = $this->get('/saluran-pelaporan')->assertOk()->assertViewIs('pages.show');
    expect($saluran->getContent())->not->toContain('<form')
        ->toContain('Saluran Pelaporan')
        ->toContain('Apa yang Terjadi Setelah Anda Melapor')
        ->toContain('Jangan pernah mengirim kata sandi');

    // Kontak
    $kontak = $this->get('/kontak')->assertOk()->assertViewIs('pages.show');
    expect($kontak->getContent())->not->toContain('<form')
        ->toContain('Kontak Resmi')
        ->toContain('Kontak Keamanan Siber & PGP');
});
