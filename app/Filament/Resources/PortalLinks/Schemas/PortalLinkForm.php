<?php

namespace App\Filament\Resources\PortalLinks\Schemas;

use App\Rules\SafeUrl;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PortalLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tautan Portal')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Nama Portal / Layanan')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('url')
                            ->label('Alamat URL')
                            ->required()
                            ->maxLength(255)
                            ->rules([new SafeUrl(allowRelative: false)])
                            ->helperText('Hanya tautan valid yang diawali http:// atau https:// (skema berbahaya seperti javascript: atau data: dilarang)'),

                        TextInput::make('icon')
                            ->label('Ikon')
                            ->default('globe')
                            ->maxLength(50)
                            ->helperText('Nama ikon (contoh: globe, shield, lock, server)'),

                        TextInput::make('sort')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->columnSpanFull()
                            ->rows(2),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ]),
            ]);
    }
}
