<?php

namespace App\Filament\Resources\MenuItems\Schemas;

use App\Models\MenuItem;
use App\Models\Page;
use App\Rules\SafeUrl;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konfigurasi Butir Menu')
                    ->columns(2)
                    ->schema([
                        Select::make('location')
                            ->label('Lokasi Menu')
                            ->options([
                                'header' => 'Header Navigasi Atas',
                                'footer' => 'Footer Bawah',
                            ])
                            ->default('header')
                            ->required(),

                        Select::make('parent_id')
                            ->label('Menu Induk (Maksimal 1 Tingkat Submenu)')
                            ->options(function ($record) {
                                return MenuItem::query()
                                    ->whereNull('parent_id')
                                    ->when($record, fn ($q) => $q->where('id', '!=', $record->id))
                                    ->pluck('label', 'id');
                            })
                            ->searchable()
                            ->nullable()
                            ->helperText('Hanya butir tanpa induk yang dapat menjadi menu induk.'),

                        TextInput::make('label')
                            ->label('Label Menu')
                            ->required()
                            ->maxLength(255),

                        Select::make('type')
                            ->label('Tipe Tautan')
                            ->options([
                                'page' => 'Halaman Dinamis (CMS)',
                                'url' => 'Tautan Kustom / Rute Tetap',
                            ])
                            ->default('page')
                            ->required()
                            ->live(),

                        Select::make('page_id')
                            ->label('Pilih Halaman')
                            ->options(Page::query()->orderBy('title')->pluck('title', 'id'))
                            ->searchable()
                            ->required(fn ($get) => $get('type') === 'page')
                            ->visible(fn ($get) => $get('type') === 'page'),

                        TextInput::make('url')
                            ->label('URL Tautan (Jalur internal atau http/https)')
                            ->required(fn ($get) => $get('type') === 'url')
                            ->visible(fn ($get) => $get('type') === 'url')
                            ->rules([new SafeUrl(allowRelative: true)])
                            ->helperText('Contoh: /berita, /layanan, /kontak, atau https://... (skema javascript: dan data: dilarang)'),

                        TextInput::make('sort')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        Toggle::make('new_tab')
                            ->label('Buka di Tab Baru (_blank)')
                            ->default(false),

                        Toggle::make('is_active')
                            ->label('Aktif Ditampilkan')
                            ->default(true),
                    ]),
            ]);
    }
}
