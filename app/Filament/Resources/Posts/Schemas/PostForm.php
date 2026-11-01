<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten Artikel')
                    ->columns(2)
                    ->schema([
                        Select::make('type')
                            ->label('Tipe Artikel')
                            ->options([
                                'news' => 'Berita',
                                'education' => 'Edukasi',
                            ])
                            ->default('news')
                            ->required()
                            ->live(),

                        Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name', modifyQueryUsing: function ($query, $get) {
                                if ($type = $get('type')) {
                                    $query->where('type', $type);
                                }
                            })
                            ->searchable()
                            ->preload(),

                        TextInput::make('title')
                            ->label('Judul')
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, $get) => blank($get('slug')) ? $set('slug', Str::slug($state)) : null),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->columnSpanFull()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Textarea::make('excerpt')
                            ->label('Ringkasan Singkat')
                            ->columnSpanFull()
                            ->rows(3),

                        RichEditor::make('body')
                            ->label('Isi Lengkap')
                            ->columnSpanFull()
                            ->required(),
                    ]),

                Section::make('Media & Berkas Pendukung')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('cover')
                            ->label('Gambar Sampul')
                            ->disk('public')
                            ->directory('covers')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(4096)
                            ->helperText('Format JPG, PNG, atau WEBP maks 4 MB. SVG ditolak demi keamanan.')
                            ->live(),

                        TextInput::make('cover_alt')
                            ->label('Teks Alternatif Sampul (Aksesibilitas)')
                            ->required(fn ($get) => filled($get('cover')))
                            ->helperText('Deskripsi gambar untuk pembaca layar (screen reader).'),

                        TextInput::make('video_url')
                            ->label('Tautan Video YouTube (Opsional)')
                            ->url()
                            ->regex('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/')
                            ->helperText('Format: https://www.youtube.com/watch?v=... atau https://youtu.be/...'),

                        FileUpload::make('download')
                            ->label('Lampiran Berkas (Opsional)')
                            ->disk('public')
                            ->directory('downloads')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->maxSize(20480)
                            ->helperText('PDF, DOCX, XLSX maks 20 MB.'),
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
