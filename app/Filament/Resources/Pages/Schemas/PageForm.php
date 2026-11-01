<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Enums\DocumentCategory;
use App\Enums\ServiceGroup;
use App\Models\Page;
use App\Rules\SafeUrl;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Halaman')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Halaman')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                if (! $get('is_home') && blank($get('slug'))) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->maxLength(255)
                            ->regex('/^[a-z0-9-]+$/')
                            ->notIn(Page::RESERVED_SLUGS)
                            ->unique(ignoreRecord: true)
                            ->helperText('Hanya huruf kecil, angka, dan tanda hubung (-).'),

                        Select::make('template')
                            ->label('Templat')
                            ->options([
                                'default' => 'Bawaan (Standar)',
                                'wide' => 'Penuh (Lebar)',
                                'home' => 'Beranda',
                            ])
                            ->default('default')
                            ->required(),

                        Select::make('parent_id')
                            ->label('Halaman Induk (Opsional)')
                            ->relationship('parent', 'title')
                            ->searchable()
                            ->preload(),

                        Toggle::make('is_home')
                            ->label('Jadikan sebagai Halaman Beranda')
                            ->helperText('Hanya ada satu halaman beranda aktif pada situs.')
                            ->default(false),
                    ]),

                Section::make('Publikasi')
                    ->columns(2)
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draf',
                                'published' => 'Terbit',
                            ])
                            ->default('draft')
                            ->required(),

                        DateTimePicker::make('published_at')
                            ->label('Terbit Pada')
                            ->timezone('Asia/Jakarta')
                            ->helperText('Kosongkan untuk langsung terbit atau atur waktu di masa depan untuk publikasi terjadwal.'),
                    ]),

                Section::make('Penyusun Blok Konten (Builder)')
                    ->collapsible()
                    ->schema([
                        Builder::make('blocks')
                            ->label('Blok Konten')
                            ->blocks([
                                Block::make('hero')
                                    ->label('Hero Banner')
                                    ->schema([
                                        TextInput::make('title')->label('Judul Hero (Kosongkan untuk memakai judul Pengaturan Situs)'),
                                        Textarea::make('subtitle')->label('Subjudul / Deskripsi (Kosongkan untuk memakai subjudul Pengaturan Situs)'),
                                        FileUpload::make('image')
                                            ->label('Foto Sampul Hero')
                                            ->disk('public')
                                            ->directory('hero')
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->maxSize(6144)
                                            ->helperText('Unggah foto sampul untuk ditampilkan di bagian kanan Hero Banner (Format JPG, PNG, WEBP maks 6 MB).'),
                                        TextInput::make('image_alt')
                                            ->label('Teks Alternatif Foto Sampul')
                                            ->default('Foto Sampul CSIRT Pemerintah Kota Pariaman'),
                                        TextInput::make('primary_label')->label('Label Tombol Utama')->default('Pengaduan'),
                                        TextInput::make('secondary_label')->label('Label Tombol Sekunder'),
                                        TextInput::make('secondary_url')
                                            ->label('Tautan Sekunder (Jalur internal / http(s))')
                                            ->rules([new SafeUrl(allowRelative: true)]),
                                    ]),

                                Block::make('rich_text')
                                    ->label('Teks Kaya / Dokumen (Gaya Word)')
                                    ->schema([
                                        RichEditor::make('content')
                                            ->label('Isi Konten Dokumen')
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'strike',
                                                'h2',
                                                'h3',
                                                'bulletList',
                                                'orderedList',
                                                'blockquote',
                                                'link',
                                                'table',
                                                'undo',
                                                'redo',
                                            ])
                                            ->helperText('Mendukung pengetikan seperti Microsoft Word: Judul (H2/H3), Huruf Tebal/Miring/Garis Bawah, Penomoran (1, 2, 3), Poin (Bullet), Kutipan, Tabel, dan Tautan.')
                                            ->required(),
                                    ]),

                                Block::make('latest_advisories')
                                    ->label('Daftar Advisori Terbaru')
                                    ->schema([
                                        TextInput::make('heading')->label('Judul Bagian')->default('Peringatan & Advisori Keamanan'),
                                        TextInput::make('count')->label('Jumlah Advisori')->numeric()->minValue(1)->maxValue(6)->default(3),
                                    ]),

                                Block::make('report_channels')
                                    ->label('Kartu Saluran Pelaporan')
                                    ->schema([
                                        TextInput::make('heading')->label('Judul Bagian (Opsional)')->placeholder('Kanal Resmi Pelaporan Insiden'),
                                    ]),

                                Block::make('steps')
                                    ->label('Langkah-Langkah (Steps)')
                                    ->schema([
                                        TextInput::make('heading')->label('Judul Bagian')->default('Alur Penanganan Insiden'),
                                        Repeater::make('items')
                                            ->label('Daftar Langkah')
                                            ->schema([
                                                TextInput::make('title')->label('Judul Langkah')->required(),
                                                Textarea::make('description')->label('Deskripsi Langkah'),
                                            ]),
                                    ]),

                                Block::make('service_cards')
                                    ->label('Kartu Layanan')
                                    ->schema([
                                        TextInput::make('heading')->label('Judul Bagian')->default('Layanan Kami'),
                                        Select::make('group')
                                            ->label('Kelompok Layanan (Opsional)')
                                            ->options(collect(ServiceGroup::cases())->mapWithKeys(fn ($g) => [$g->value => $g->label()])),
                                        TextInput::make('count')->label('Batas Jumlah')->numeric()->default(6),
                                    ]),

                                Block::make('latest_posts')
                                    ->label('Berita & Edukasi Terbaru')
                                    ->schema([
                                        TextInput::make('heading')->label('Judul Bagian')->default('Kabar & Informasi Siber Terkini'),
                                        Select::make('type')
                                            ->label('Tipe Artikel')
                                            ->options([
                                                'news' => 'Berita',
                                                'education' => 'Edukasi',
                                            ])
                                            ->default('news'),
                                        TextInput::make('count')->label('Jumlah Artikel')->numeric()->default(3),
                                    ]),

                                Block::make('portal_links')
                                    ->label('Tautan Portal Layanan')
                                    ->schema([
                                        TextInput::make('heading')->label('Judul Bagian')->default('Layanan Siber Terpadu'),
                                    ]),

                                Block::make('contact_block')
                                    ->label('Blok Kontak Darurat')
                                    ->schema([
                                        TextInput::make('heading')->label('Judul Bagian')->default('Hubungi Tim CSIRT'),
                                    ]),

                                Block::make('document_list')
                                    ->label('Daftar Dokumen')
                                    ->schema([
                                        TextInput::make('heading')->label('Judul Bagian')->default('Dokumen Terkait'),
                                        Select::make('category')
                                            ->label('Kategori Dokumen')
                                            ->options(collect(DocumentCategory::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()])),
                                    ]),

                                Block::make('agent_table')
                                    ->label('Tabel Agen Siber')
                                    ->schema([
                                        TextInput::make('heading')->label('Judul Bagian')->default('Daftar Agen Siber OPD'),
                                    ]),

                                Block::make('callout')
                                    ->label('Pemberitahuan (Callout)')
                                    ->schema([
                                        Select::make('level')
                                            ->label('Tingkat')
                                            ->options([
                                                'info' => 'Informasi (Biru)',
                                                'warning' => 'Peringatan (Kuning/Emas)',
                                                'danger' => 'Bahaya / Kritis (Merah)',
                                            ])
                                            ->default('info'),
                                        Textarea::make('text')->label('Isi Pemberitahuan')->required(),
                                    ]),

                                Block::make('button')
                                    ->label('Tombol Aksi')
                                    ->schema([
                                        TextInput::make('label')->label('Label Tombol')->required(),
                                        TextInput::make('url')
                                            ->label('Tautan URL (Internal / http(s))')
                                            ->required()
                                            ->rules([new SafeUrl(allowRelative: true)]),
                                    ]),
                            ])
                            ->collapsible(),
                    ]),

                Section::make('Optimasi Mesin Pencari (SEO)')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextInput::make('seo_title')->label('Judul SEO (Meta Title)'),
                        Textarea::make('seo_description')->label('Deskripsi SEO (Meta Description)'),
                    ]),
            ]);
    }
}
