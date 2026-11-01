<?php

use App\Models\Advisory;
use App\Models\Agent;
use App\Models\Document;
use App\Models\Event;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\PortalLink;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SiteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RoleSeeder::class);
    $this->seed(SiteSeeder::class);

    $this->superadmin = User::factory()->create();
    $this->superadmin->assignRole('superadmin');
});

it('renders the create form of every admin resource', function (string $slug) {
    $this->actingAs($this->superadmin)
        ->get("/panel-csirt/{$slug}/create")
        ->assertOk();
})->with([
    'pages', 'posts', 'categories', 'advisories', 'documents', 'services',
    'agents', 'events', 'portal-links', 'menu-items', 'users',
]);

it('renders the edit form of every admin resource', function (string $slug, string $model) {
    $record = $model::query()->first();

    expect($record)->not->toBeNull();

    $this->actingAs($this->superadmin)
        ->get("/panel-csirt/{$slug}/{$record->getKey()}/edit")
        ->assertOk();
})->with([
    'pages' => ['pages', Page::class],
    'posts' => ['posts', Post::class],
    'advisories' => ['advisories', Advisory::class],
    'documents' => ['documents', Document::class],
    'services' => ['services', Service::class],
    'agents' => ['agents', Agent::class],
    'events' => ['events', Event::class],
    'portal-links' => ['portal-links', PortalLink::class],
    'menu-items' => ['menu-items', MenuItem::class],
    'users' => ['users', User::class],
]);
