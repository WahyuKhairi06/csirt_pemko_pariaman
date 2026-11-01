<?php

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SiteSeeder;
use Database\Seeders\UserSeeder;
use Filament\Auth\Pages\Login;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    $this->seed(SiteSeeder::class);
});

it('redirects unauthenticated guests to login page when accessing panel-csirt', function () {
    $this->get('/panel-csirt')->assertRedirect('/panel-csirt/login');
    $this->get('/panel-csirt/pages')->assertRedirect('/panel-csirt/login');
    $this->get('/panel-csirt/advisories')->assertRedirect('/panel-csirt/login');
    $this->get('/panel-csirt/manage-settings')->assertRedirect('/panel-csirt/login');
});

it('redirects /admin to /panel-csirt', function () {
    $this->get('/admin')->assertRedirect('/panel-csirt');
});

it('denies panel access to users with standard user role', function () {
    $user = User::factory()->create();
    $user->assignRole('user');

    $this->actingAs($user)->get('/panel-csirt')->assertForbidden();
    $this->actingAs($user)->get('/panel-csirt/pages')->assertForbidden();
    $this->actingAs($user)->get('/panel-csirt/manage-settings')->assertForbidden();
});

it('grants full panel access to superadmin', function () {
    $superadmin = User::factory()->create();
    $superadmin->assignRole('superadmin');

    $this->actingAs($superadmin)->get('/panel-csirt')->assertOk();
    $this->actingAs($superadmin)->get('/panel-csirt/pages')->assertOk();
    $this->actingAs($superadmin)->get('/panel-csirt/posts')->assertOk();
    $this->actingAs($superadmin)->get('/panel-csirt/categories')->assertOk();
    $this->actingAs($superadmin)->get('/panel-csirt/advisories')->assertOk();
    $this->actingAs($superadmin)->get('/panel-csirt/documents')->assertOk();
    $this->actingAs($superadmin)->get('/panel-csirt/services')->assertOk();
    $this->actingAs($superadmin)->get('/panel-csirt/agents')->assertOk();
    $this->actingAs($superadmin)->get('/panel-csirt/events')->assertOk();
    $this->actingAs($superadmin)->get('/panel-csirt/portal-links')->assertOk();
    $this->actingAs($superadmin)->get('/panel-csirt/menu-items')->assertOk();
    $this->actingAs($superadmin)->get('/panel-csirt/users')->assertOk();
    $this->actingAs($superadmin)->get('/panel-csirt/manage-settings')->assertOk();
});

it('enforces coordinator permissions: can manage content and settings, but cannot manage users', function () {
    $koordinator = User::factory()->create();
    $koordinator->assignRole('koordinator');

    $this->actingAs($koordinator)->get('/panel-csirt')->assertOk();
    $this->actingAs($koordinator)->get('/panel-csirt/pages')->assertOk();
    $this->actingAs($koordinator)->get('/panel-csirt/advisories')->assertOk();
    $this->actingAs($koordinator)->get('/panel-csirt/documents')->assertOk();
    $this->actingAs($koordinator)->get('/panel-csirt/services')->assertOk();
    $this->actingAs($koordinator)->get('/panel-csirt/menu-items')->assertOk();
    $this->actingAs($koordinator)->get('/panel-csirt/manage-settings')->assertOk();

    // Koordinator tidak memiliki hak kelola akun pengguna
    $this->actingAs($koordinator)->get('/panel-csirt/users')->assertForbidden();
});

it('enforces analyst permissions: can manage advisories, documents, services, but not pages, news, settings, or users', function () {
    $analis = User::factory()->create();
    $analis->assignRole('analis');

    $this->actingAs($analis)->get('/panel-csirt')->assertOk();
    $this->actingAs($analis)->get('/panel-csirt/advisories')->assertOk();
    $this->actingAs($analis)->get('/panel-csirt/documents')->assertOk();
    $this->actingAs($analis)->get('/panel-csirt/services')->assertOk();

    // Analis dilarang mengakses konten publik umum, menu, pengaturan, dan pengguna
    $this->actingAs($analis)->get('/panel-csirt/pages')->assertForbidden();
    $this->actingAs($analis)->get('/panel-csirt/posts')->assertForbidden();
    $this->actingAs($analis)->get('/panel-csirt/menu-items')->assertForbidden();
    $this->actingAs($analis)->get('/panel-csirt/manage-settings')->assertForbidden();
    $this->actingAs($analis)->get('/panel-csirt/users')->assertForbidden();
});

it('enforces editor permissions: can manage pages, news, events, but not advisories, documents, settings, or users', function () {
    $editor = User::factory()->create();
    $editor->assignRole('editor');

    $this->actingAs($editor)->get('/panel-csirt')->assertOk();
    $this->actingAs($editor)->get('/panel-csirt/pages')->assertOk();
    $this->actingAs($editor)->get('/panel-csirt/posts')->assertOk();
    $this->actingAs($editor)->get('/panel-csirt/categories')->assertOk();
    $this->actingAs($editor)->get('/panel-csirt/events')->assertOk();

    // Editor dilarang mengakses dokumen keamanan, advisori, pengaturan, dan pengguna
    $this->actingAs($editor)->get('/panel-csirt/advisories')->assertForbidden();
    $this->actingAs($editor)->get('/panel-csirt/documents')->assertForbidden();
    $this->actingAs($editor)->get('/panel-csirt/services')->assertForbidden();
    $this->actingAs($editor)->get('/panel-csirt/menu-items')->assertForbidden();
    $this->actingAs($editor)->get('/panel-csirt/manage-settings')->assertForbidden();
    $this->actingAs($editor)->get('/panel-csirt/users')->assertForbidden();
});

it('ensures public views have no admin login or registration links', function () {
    $publicPages = ['/', '/layanan', '/agen-siber', '/dokumen', '/agenda', '/advisori', '/berita', '/saluran-pelaporan', '/kontak'];

    foreach ($publicPages as $path) {
        $html = $this->get($path)->assertOk()->getContent();
        expect($html)
            ->not->toContain('/panel-csirt/login')
            ->not->toContain('/panel-csirt/register')
            ->not->toContain('name="password"')
            ->not->toContain('Daftar Akun')
            ->not->toContain('Masuk Admin');
    }
});

it('idempotently seeds users and roles via UserSeeder', function () {
    $this->seed(UserSeeder::class);

    $superadmin = User::where('email', 'superadmin@csirt.pariamankota.go.id')->first();
    expect($superadmin)->not->toBeNull()
        ->and($superadmin->hasRole('superadmin'))->toBeTrue();

    $normalUser = User::where('email', 'user@csirt.pariamankota.go.id')->first();
    expect($normalUser)->not->toBeNull()
        ->and($normalUser->hasRole('user'))->toBeTrue()
        ->and($normalUser->hasRole('superadmin'))->toBeFalse();

    // Seed ulang untuk memastikan idempoten tanpa error duplikasi
    $this->seed(UserSeeder::class);
    expect(User::where('email', 'superadmin@csirt.pariamankota.go.id')->count())->toBe(1);
});

it('authenticates superadmin via the Filament login page', function () {
    $this->seed(UserSeeder::class);

    Filament::setCurrentPanel(Filament::getPanel('admin'));

    Livewire::test(Login::class)
        ->fillForm([
            'email' => 'superadmin@csirt.pariamankota.go.id',
            'password' => 'PariamanCsirt#2026!',
        ])
        ->call('authenticate')
        ->assertHasNoErrors()
        ->assertRedirect('/panel-csirt');

    $this->assertAuthenticated();
});

it('rejects standard user from authenticating into the panel via login page', function () {
    $this->seed(UserSeeder::class);

    Filament::setCurrentPanel(Filament::getPanel('admin'));

    Livewire::test(Login::class)
        ->fillForm([
            'email' => 'user@csirt.pariamankota.go.id',
            'password' => 'PariamanCsirt#2026!',
        ])
        ->call('authenticate')
        ->assertHasErrors();

    $this->assertGuest();
});
