<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Enums\PostType;
use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')
                    ->label('Sampul')
                    ->disk('public')
                    ->square(),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof PostType ? $state->label() : ($state === 'news' ? 'Berita' : 'Edukasi')),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($record) => $record->publicationLabel())
                    ->color(fn ($record) => match ($record->publicationLabel()) {
                        'Terbit' => 'success',
                        'Terjadwal' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('published_at')
                    ->label('Waktu Terbit')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'news' => 'Berita',
                        'education' => 'Edukasi',
                    ]),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draf',
                        'published' => 'Terbit',
                    ]),
            ])
            ->recordActions([
                Action::make('preview')
                    ->label('Pratinjau')
                    ->icon(Heroicon::ArrowTopRightOnSquare)
                    ->url(fn (Post $record) => route('preview.post', $record))
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
