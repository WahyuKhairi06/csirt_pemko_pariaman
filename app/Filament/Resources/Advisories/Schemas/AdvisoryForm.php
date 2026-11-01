<?php

namespace App\Filament\Resources\Advisories\Schemas;

use App\Enums\Severity;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AdvisoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Advisori')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Advisori')
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

                        Select::make('severity')
                            ->label('Tingkat Keparahan')
                            ->options(collect(Severity::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()]))
                            ->required(),

                        Textarea::make('summary')
                            ->label('Ringkasan Ancaman')
                            ->columnSpanFull()
                            ->required()
                            ->rows(3),

                        Textarea::make('affected_systems')
                            ->label('Sistem Terdampak')
                            ->columnSpanFull()
                            ->rows(2)
                            ->helperText('Contoh: Linux Kernel < 6.8, Apache HTTP Server 2.4.x'),

                        RichEditor::make('mitigation')
                            ->label('Langkah Mitigasi & Rekomendasi')
                            ->columnSpanFull()
                            ->required(),
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
                            ->label('Waktu Terbit')
                            ->timezone('Asia/Jakarta')
                            ->helperText('Kosongkan untuk langsung terbit atau tentukan waktu di masa depan.'),
                    ]),
            ]);
    }
}
