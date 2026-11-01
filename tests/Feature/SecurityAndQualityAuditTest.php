<?php

use App\Models\Advisory;
use App\Models\Post;
use App\Models\User;
use App\Rules\SafeUrl;
use App\Support\Html;
use App\Support\Settings;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SiteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    $this->seed(SiteSeeder::class);
});

it('ensures all public pages are accessible without authentication', function () {
    $publicRoutes = [
        '/',
        '/layanan',
        '/agen-siber',
        '/dokumen',
        '/agenda',
        '/advisori',
        '/berita',
        '/edukasi',
        '/saluran-pelaporan',
        '/kontak',
    ];

    foreach ($publicRoutes as $route) {
        $this->get($route)->assertOk();
    }
});

it('verifies published advisory and post detail pages are accessible to guests', function () {
    $advisory = Advisory::where('status', 'published')->first();
    if ($advisory) {
        $this->get('/advisori/'.$advisory->slug)->assertOk();
    }

    $post = Post::where('status', 'published')->first();
    if ($post) {
        $prefix = $post->type->value === 'news' ? '/berita/' : '/edukasi/';
        $this->get($prefix.$post->slug)->assertOk();
    }
});

it('verifies there are strictly no unapproved public write endpoints', function () {
    $allowedPrefixes = ['panel-csirt', 'livewire', 'filament', 'storage', 'up', 'sanctum'];

    $writeRoutes = collect(Route::getRoutes()->getRoutes())
        ->filter(fn ($route) => array_intersect($route->methods(), ['POST', 'PUT', 'PATCH', 'DELETE']) !== [])
        ->reject(fn ($route) => collect($allowedPrefixes)->contains(fn ($prefix) => str_starts_with(ltrim($route->uri(), '/'), $prefix)))
        ->map(fn ($route) => implode('|', $route->methods()).' '.$route->uri())
        ->values()
        ->all();

    expect($writeRoutes)->toBe([]);
});

it('verifies no public pages contain interactive form submissions or password inputs', function () {
    $publicRoutes = [
        '/',
        '/layanan',
        '/agen-siber',
        '/dokumen',
        '/agenda',
        '/advisori',
        '/berita',
        '/saluran-pelaporan',
        '/kontak',
    ];

    foreach ($publicRoutes as $route) {
        $html = $this->get($route)->getContent();

        // Tidak boleh ada tag form dengan method post pada tampilan publik
        expect($html)->not->toMatch('/<form[^>]*method=["\']post["\']/i')
            ->not->toContain('name="password"')
            ->not->toContain('type="password"');
    }
});

it('sanitizes rich text against XSS, scripts, and dangerous inline handlers', function () {
    $dirty = '<p>Paragraf aman</p><script>alert("XSS")</script><img src="x" onerror="alert(1)"><a href="javascript:alert(2)">Tautan</a>';
    $clean = Html::clean($dirty);

    expect($clean)
        ->not->toContain('<script')
        ->not->toContain('alert(')
        ->not->toContain('onerror=')
        ->not->toContain('javascript:');
});

it('validates URLs and strictly rejects dangerous schemes via SafeUrl rule', function () {
    $invalidUrls = [
        'javascript:alert(1)',
        'JAVASCRIPT:alert(document.cookie)',
        'data:text/html,<script>alert(1)</script>',
        'vbscript:msgbox(1)',
        'file:///etc/shadow',
        '//attacker.com/evil',
        "https://domain.com\ninvalid",
    ];

    foreach ($invalidUrls as $url) {
        $validator = Validator::make(['url' => $url], [
            'url' => [new SafeUrl(allowRelative: true)],
        ]);

        expect($validator->fails())->toBeTrue("URL '{$url}' should have been rejected by SafeUrl rule.");
    }

    $validUrls = [
        '/berita',
        '/layanan/respons-insiden',
        'https://pariamankota.go.id',
        'https://csirt.sumbarprov.go.id',
    ];

    foreach ($validUrls as $url) {
        $validator = Validator::make(['url' => $url], [
            'url' => [new SafeUrl(allowRelative: true)],
        ]);

        expect($validator->passes())->toBeTrue("URL '{$url}' should have been accepted by SafeUrl rule.");
    }
});

it('ensures placeholder contacts are not rendered as active clickable links', function () {
    $response = $this->get('/kontak');
    $html = $response->getContent();

    // Pastikan tidak ada tautan tel: atau mailto: ke placeholder [ISI: ...]
    expect($html)
        ->not->toContain('href="tel:[ISI')
        ->not->toContain('href="mailto:[ISI')
        ->not->toContain('href="[ISI');

    // TelHref dan MailHref menghasilkan null pada placeholder
    expect(Settings::telHref('[ISI: nomor telepon]'))->toBeNull();
    expect(Settings::mailHref('[ISI: email keamanan]'))->toBeNull();
});

it('ensures all images rendered on public pages have alt attributes', function () {
    $response = $this->get('/berita');
    $html = $response->getContent();

    // Jika ada tag img, harus memiliki atribut alt
    if (preg_match_all('/<img[^>]*>/i', $html, $matches)) {
        foreach ($matches[0] as $imgTag) {
            expect($imgTag)->toMatch('/alt=["\'][^"\']*["\']/i');
        }
    }
});

it('verifies Filament admin panel and resources are server-protected', function () {
    // Tamu tanpa login ditolak ke login
    $this->get('/panel-csirt')->assertRedirect('/panel-csirt/login');
    $this->get('/panel-csirt/pages')->assertRedirect('/panel-csirt/login');
    $this->get('/panel-csirt/manage-settings')->assertRedirect('/panel-csirt/login');

    // Pengguna ber-role user ditolak (403 Forbidden)
    $user = User::factory()->create();
    $user->assignRole('user');

    $this->actingAs($user)->get('/panel-csirt')->assertForbidden();
    $this->actingAs($user)->get('/panel-csirt/pages')->assertForbidden();
    $this->actingAs($user)->get('/panel-csirt/manage-settings')->assertForbidden();
});
