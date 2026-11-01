<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Enums\DocumentCategory;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dokumen')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Dokumen')
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(255),

                        Select::make('category')
                            ->label('Kategori Dokumen')
                            ->options(collect(DocumentCategory::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()]))
                            ->required(),

                        TextInput::make('version')
                            ->label('Versi')
                            ->default('v1.0')
                            ->maxLength(20),

                        TextInput::make('language')
                            ->label('Bahasa')
                            ->default('id')
                            ->maxLength(10),

                        DatePicker::make('effective_date')
                            ->label('Tanggal Berlaku'),

                        TextInput::make('sort')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        FileUpload::make('file')
                            ->label('Berkas Dokumen')
                            ->columnSpanFull()
                            ->disk('public')
                            ->directory('documents')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->maxSize(20480)
                            ->required()
                            ->helperText('Format PDF, DOCX, atau XLSX maks 20 MB.'),
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
