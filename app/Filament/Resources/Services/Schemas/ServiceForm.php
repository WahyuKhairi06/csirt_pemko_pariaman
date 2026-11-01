<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Enums\ServiceGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Layanan')
                    ->columns(2)
                    ->schema([
                        Select::make('group')
                            ->label('Kelompok Layanan')
                            ->options(collect(ServiceGroup::cases())->mapWithKeys(fn ($g) => [$g->value => $g->label()]))
                            ->required(),

                        TextInput::make('name')
                            ->label('Nama Layanan')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, $get) => blank($get('slug')) ? $set('slug', Str::slug($state)) : null),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('sort')
                            ->label('Urutan Tampilan')
                            ->numeric()
                            ->default(0),

                        Textarea::make('description')
                            ->label('Deskripsi Layanan')
                            ->columnSpanFull()
                            ->required()
                            ->rows(3),

                        TextInput::make('who_can_request')
                            ->label('Sasaran Pemohon')
                            ->default('Organisasi Perangkat Daerah (OPD) Pemko Pariaman')
                            ->maxLength(255),

                        TextInput::make('how_to_request')
                            ->label('Mekanisme Permohonan')
                            ->default('Melalui Saluran Resmi Pelaporan CSIRT Kota Pariaman')
                            ->maxLength(255),

                        TextInput::make('hours')
                            ->label('Jam Layanan')
                            ->default('Senin - Jumat, 08.00 - 16.00 WIB')
                            ->maxLength(255),

                        TextInput::make('response_target')
                            ->label('Target Waktu Respons (SLA)')
                            ->default('Maksimal 1 x 24 Jam')
                            ->maxLength(255),
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
                            ->default('published')
                            ->required(),

                        DateTimePicker::make('published_at')
                            ->label('Waktu Terbit')
                            ->timezone('Asia/Jakarta'),
                    ]),
            ]);
    }
}
