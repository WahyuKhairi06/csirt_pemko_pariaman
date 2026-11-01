<?php

// Uji penerimaan situs publik hanya-baca (Pest). Kode starter ini BELUM pernah dijalankan di Laravel hidup:
// penyusunnya tidak bisa mengakses Packagist, hanya sintaks PHP yang diperiksa. Jalankan `php artisan test`
// lalu sesuaikan. Uji yang memakai assertViewIs mengandaikan nama view: pages.show, posts.index, posts.show,
// advisories.index, advisories.show, documents.index, services.index, agents.index, events.index (references/CMS-SPEC.md bagian 8).

use App\Enums\MenuLocation;
use App\Enums\PostType;
use App\Enums\PublishStatus;
use App\Enums\ReportChannelType;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use App\Support\Html;
use App\Support\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

function makePage(array $attrs = []): Page
{
    return Page::create($attrs + [
        'title' => 'Halaman Uji',
        'slug' => 'halaman-uji',
        'status' => PublishStatus::Published->value,
        'published_at' => now()->subMinute(),
        'blocks' => [['type' => 'rich_text', 'data' => ['content' => '<p>Isi uji</p>']]],
    ]);
}

it('shows a published page and hides drafts', function () {
    makePage();
    makePage(['title' => 'Draf', 'slug' => 'draf', 'status' => PublishStatus::Draft->value]);

    $this->get('/halaman-uji')->assertOk()->assertViewIs('pages.show');
    $this->get('/draf')->assertNotFound();
});

it('hides scheduled content until its time arrives', function () {
    makePage(['slug' => 'nanti', 'published_at' => now()->addDay()]);

    $this->get('/nanti')->assertNotFound();

    $this->travel(2)->days();

    $this->get('/nanti')->assertOk();
});

it('never lets a dynamic page shadow a fixed route', function () {
    makePage(['title' => 'Palsu', 'slug' => 'advisori']);

    $this->get('/advisori')->assertOk()->assertViewIs('advisories.index');
});

it('keeps the home page at the root only', function () {
    makePage(['slug' => 'beranda', 'is_home' => true]);

    $this->get('/')->assertOk();
    $this->get('/beranda')->assertRedirect('/');
});

it('lists only published posts of the requested type', function () {
    Post::create(['type' => PostType::News->value, 'title' => 'Terbit', 'slug' => 'terbit', 'body' => 'x',
        'status' => PublishStatus::Published->value, 'published_at' => now()->subHour()]);
    Post::create(['type' => PostType::News->value, 'title' => 'Draf', 'slug' => 'draf-berita', 'body' => 'x',
        'status' => PublishStatus::Draft->value]);
    Post::create(['type' => PostType::Education->value, 'title' => 'Edukasi', 'slug' => 'edukasi-1', 'body' => 'x',
        'status' => PublishStatus::Published->value, 'published_at' => now()->subHour()]);

    $response = $this->get('/berita')->assertOk()->assertViewIs('posts.index');
    expect($response->viewData('posts')->pluck('slug')->all())->toBe(['terbit']);
    $this->get('/berita/draf-berita')->assertNotFound();
    $this->get('/berita/edukasi-1')->assertNotFound();
});

it('exposes no public write endpoints', function () {
    // Prinsip PRD v0.2: semua input dari admin. Sesuaikan daftar awalan bila paket lain menambah rute tulis.
    $allowed = ['panel-csirt', 'livewire', 'filament', 'storage', 'up', 'sanctum'];

    $writes = collect(Route::getRoutes()->getRoutes())
        ->filter(fn ($route) => array_intersect($route->methods(), ['POST', 'PUT', 'PATCH', 'DELETE']) !== [])
        ->reject(fn ($route) => collect($allowed)->contains(fn ($p) => str_starts_with(ltrim($route->uri(), '/'), $p)))
        ->map(fn ($route) => implode('|', $route->methods()).' '.$route->uri())
        ->values()
        ->all();

    expect($writes)->toBe([]);
});

it('sends security headers on public pages', function () {
    makePage();

    $this->get('/halaman-uji')
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
});

it('builds security.txt from settings and 404s until the email is real', function () {
    Settings::set('contact.email_security', '[ISI: email keamanan]');
    $this->get('/.well-known/security.txt')->assertNotFound();

    Settings::set('contact.email_security', 'csirt@example.test');
    $this->get('/.well-known/security.txt')
        ->assertOk()
        ->assertSee('Contact: mailto:csirt@example.test', false)
        ->assertSee('Expires: ', false);
});

it('points the report button where the admin says, and rejects unsafe values', function () {
    expect(Settings::reportCtaUrl())->toBe('/saluran-pelaporan');

    Settings::set('report.cta_type', 'email');
    Settings::set('report.cta_value', 'lapor@example.test');
    expect(Settings::reportCtaUrl())->toBe('mailto:lapor@example.test');

    Settings::set('report.cta_type', 'url');
    Settings::set('report.cta_value', 'javascript:alert(1)');
    expect(Settings::reportCtaUrl())->toBe('/saluran-pelaporan');
});

it('builds safe channel links and hides placeholder channels', function () {
    expect(ReportChannelType::Whatsapp->href('0812-3456-7890'))->toBe('https://wa.me/6281234567890');
    expect(ReportChannelType::Email->href('bukan-email'))->toBe('#');
    expect(ReportChannelType::Url->href('data:text/html,x'))->toBe('#');

    Settings::set('report.channels', [
        ['type' => 'email', 'label' => 'Email', 'value' => '[ISI: email pelaporan]', 'enabled' => true],
        ['type' => 'email', 'label' => 'Email', 'value' => 'lapor@example.test', 'enabled' => true],
        ['type' => 'phone', 'label' => 'Telepon', 'value' => '0751123456', 'enabled' => false],
    ]);

    expect(array_column(Settings::reportChannels(), 'value'))->toBe(['lapor@example.test']);
});

it('nests menu items one level and skips inactive or unsafe ones', function () {
    $about = makePage(['slug' => 'profil', 'title' => 'Profil']);
    $draft = makePage(['slug' => 'belum', 'status' => PublishStatus::Draft->value]);

    $parent = MenuItem::create(['location' => 'header', 'label' => 'Informasi', 'type' => 'url', 'url' => '/berita', 'sort' => 0]);
    MenuItem::create(['location' => 'header', 'parent_id' => $parent->id, 'label' => 'Advisori', 'type' => 'url', 'url' => '/advisori', 'sort' => 0]);
    MenuItem::create(['location' => 'header', 'label' => 'Profil', 'type' => 'page', 'page_id' => $about->id, 'sort' => 1]);
    MenuItem::create(['location' => 'header', 'label' => 'Draf', 'type' => 'page', 'page_id' => $draft->id, 'sort' => 2]);
    MenuItem::create(['location' => 'header', 'label' => 'Jahat', 'type' => 'url', 'url' => 'javascript:alert(1)', 'sort' => 3]);
    MenuItem::create(['location' => 'header', 'label' => 'Mati', 'type' => 'url', 'url' => '/mati', 'sort' => 4, 'is_active' => false]);

    $tree = MenuItem::tree(MenuLocation::Header);

    expect(array_column($tree, 'label'))->toBe(['Informasi', 'Profil']);
    expect($tree[0]['children'][0]['url'])->toBe('/advisori');
    expect($tree[1]['url'])->toBe('/profil');
});

it('never lets rich text carry scripts', function () {
    $clean = Html::clean('<p>Halo</p><script>alert(1)</script><img src="x" onerror="alert(1)">');

    expect($clean)->not->toContain('<script')->not->toContain('onerror');
});
