<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Agenda')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Nama Kegiatan / Agenda')
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, $get) => blank($get('slug')) ? $set('slug', Str::slug($state)) : null),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('location')
                            ->label('Lokasi')
                            ->maxLength(255),

                        DateTimePicker::make('starts_at')
                            ->label('Waktu Mulai')
                            ->required()
                            ->timezone('Asia/Jakarta'),

                        DateTimePicker::make('ends_at')
                            ->label('Waktu Selesai')
                            ->timezone('Asia/Jakarta')
                            ->afterOrEqual('starts_at'),

                        Textarea::make('description')
                            ->label('Deskripsi Kegiatan')
                            ->columnSpanFull()
                            ->rows(3),
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
