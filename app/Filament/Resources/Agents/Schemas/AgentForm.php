<?php

namespace App\Filament\Resources\Agents\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AgentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Agen Siber OPD')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('opd')
                            ->label('Instansi / OPD')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Contoh: Dinas Komunikasi dan Informatika'),

                        TextInput::make('position')
                            ->label('Jabatan')
                            ->maxLength(255)
                            ->helperText('Contoh: Pranata Komputer Ahli Muda'),

                        TextInput::make('contact')
                            ->label('Kontak Resmi (Email/Telepon Dinas)')
                            ->maxLength(255),

                        TextInput::make('sort')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),

                        FileUpload::make('photo')
                            ->label('Foto Resmi (Opsional)')
                            ->columnSpanFull()
                            ->disk('public')
                            ->directory('agents')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(4096)
                            ->helperText('Format JPG, PNG, atau WEBP maks 4 MB.'),
                    ]),
            ]);
    }
}
