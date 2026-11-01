<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Model data: PRD.md bagian 11. Semua data ini diisi lewat panel admin (CMS-SPEC.md); situs publik hanya membaca.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('pages')->nullOnDelete(); // untuk remah roti, URL tetap /{slug}
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('template', 24)->default('default');   // default | wide | home
            $table->json('blocks')->nullable();                   // keluaran Filament Builder: [{type, data}, ...]
            $table->string('status', 16)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->boolean('is_home')->default(false);
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 300)->nullable();
            $table->string('seo_image')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('type', 16);                           // news | education
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->unique(['type', 'slug']);
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('type', 16)->index();                  // news | education
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body');                             // HTML dari editor teks kaya; dibersihkan saat ditampilkan
            $table->string('cover')->nullable();
            $table->string('cover_alt')->nullable();              // wajib bila ada sampul (aksesibilitas)
            $table->string('video_url')->nullable();              // embed YouTube untuk edukasi
            $table->string('download')->nullable();               // infografis/berkas unduhan
            $table->string('status', 16)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('advisories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('severity', 16)->index();              // low | medium | high | critical
            $table->text('summary');
            $table->text('affected_systems')->nullable();
            $table->longText('mitigation');
            $table->string('status', 16)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category', 24)->index();              // rfc2350 | regulation | sop | guide | other
            $table->string('file');                               // jalur di disk publik
            $table->string('version', 32)->nullable();
            $table->string('language', 2)->default('id');
            $table->date('effective_date')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->string('status', 16)->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('group', 16)->index();                 // reactive | proactive | quality
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('who_can_request')->nullable();
            $table->text('how_to_request')->nullable();
            $table->string('hours')->nullable();
            $table->string('response_target')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->string('status', 16)->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('opd')->index();
            $table->string('position')->nullable();
            $table->string('contact')->nullable();                // kontak RESMI saja
            $table->string('photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->timestamp('starts_at')->index();
            $table->timestamp('ends_at')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('status', 16)->default('draft')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // Galeri (FR-23, fase 3): tabel disiapkan, model dan controller menyusul.
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->json('images')->nullable();                   // [{path, alt}, ...]
            $table->string('status', 16)->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('portal_links', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('icon', 40)->nullable();
            $table->string('url');
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('location', 16)->index();              // header | footer
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->cascadeOnDelete();
            $table->string('label');
            $table->string('type', 8)->default('url');            // page | url (berita dll. lewat url internal, mis. /berita)
            $table->foreignId('page_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->string('url')->nullable();
            $table->boolean('new_tab')->default(false);
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->json('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach ([
            'settings', 'menu_items', 'portal_links', 'galleries', 'events', 'agents',
            'services', 'documents', 'advisories', 'posts', 'categories', 'pages',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
