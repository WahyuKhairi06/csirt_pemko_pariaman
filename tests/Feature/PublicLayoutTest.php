<?php

// Uji kerangka tampilan publik (layout, navigasi, footer, 404). Basis data uji: SQLite memori + SiteSeeder.

use App\Models\Setting;
use App\Support\Settings;
use Database\Seeders\SiteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(SiteSeeder::class);
});

it('renders the home page with semantic landmarks and a single h1', function () {
    $response = $this->get('/')->assertOk();

    $html = $response->getContent();

    expect($html)
        ->toContain('<header')
        ->toContain('<main id="konten-utama"')
        ->toContain('<footer')
        ->toContain('href="#konten-utama"')
        ->toContain('lang="id"')
        ->and(substr_count($html, '<h1'))->toBe(1);
});

it('lets the nav be operated as a disclosure with valid aria wiring', function () {
    $html = $this->get('/')->assertOk()->getContent();

    preg_match_all('/<button[^>]*data-nav-toggle[^>]*>/', $html, $matches);
    expect($matches[0])->not->toBeEmpty();

    foreach ($matches[0] as $button) {
        expect($button)->toContain('aria-expanded="false"')->toContain('aria-controls="');

        preg_match('/aria-controls="([^"]+)"/', $button, $id);
        expect($html)->toContain('id="'.$id[1].'"');
    }
});

it('points the Lapor Insiden button to the destination from settings', function () {
    $this->get('/')->assertOk()->assertSee('href="/saluran-pelaporan"', false);

    Settings::set('report.cta_type', 'url');
    Settings::set('report.cta_value', 'https://helpdesk.example.org/lapor');

    $this->get('/')->assertOk()->assertSee('href="https://helpdesk.example.org/lapor"', false);
});

it('never renders dead links or public forms', function () {
    $html = $this->get('/')->assertOk()->getContent();

    expect($html)->not->toContain('href="#"')->not->toContain('<form');
});

it('shows placeholders in development but never as links, and hides them in production', function () {
    $this->get('/')->assertOk()->assertSee('[ISI: email keamanan]', false);
    expect($this->get('/')->getContent())->not->toContain('mailto:[ISI');

    $this->app->instance('env', 'production');

    $this->get('/')->assertOk()->assertDontSee('[ISI', false);
});

it('turns real contact values into tel and mailto links', function () {
    Settings::set('contact.phone', '(0751) 123 456');
    Settings::set('contact.email_security', 'csirt@example.org');

    $this->get('/')->assertOk()
        ->assertSee('href="tel:0751123456"', false)
        ->assertSee('href="mailto:csirt@example.org"', false);
});

it('only links social profiles that are valid http(s) URLs', function () {
    Setting::query()->updateOrCreate(['key' => 'social.facebook'], ['value' => 'javascript:alert(1)']);
    Setting::query()->updateOrCreate(['key' => 'social.instagram'], ['value' => 'https://www.instagram.com/contoh']);
    Settings::flush();

    $this->get('/')->assertOk()
        ->assertSee('href="https://www.instagram.com/contoh"', false)
        ->assertDontSee('javascript:alert', false);
});

it('shows the emergency banner with icon and text when enabled', function () {
    Settings::set('emergency.enabled', true);
    Settings::set('emergency.text', 'Layanan sedang terganggu.');
    Settings::set('emergency.level', 'danger');

    $this->get('/')->assertOk()->assertSee('Layanan sedang terganggu.')->assertSee('aria-label="Pemberitahuan penting"', false);
});

it('renders a 404 inside the site layout with a way back', function () {
    $this->get('/halaman-yang-tidak-ada')
        ->assertNotFound()
        ->assertSee('Halaman ini tidak ditemukan')
        ->assertSee('Kembali ke beranda')
        ->assertSee('<header', false);
});

it('sends security headers on public pages', function () {
    $this->get('/')->assertOk()
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('Content-Security-Policy');
});

it('marks the current page in the navigation', function () {
    $this->get('/profil')->assertOk()->assertSee('aria-current="page"', false);
});
