<?php

namespace App\Filament\Resources\Documents\Tables;

use App\Enums\DocumentCategory;
use App\Models\Document;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof DocumentCategory ? $state->label() : ucfirst($state)),
                TextColumn::make('version')
                    ->label('Versi')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('effective_date')
                    ->label('Berlaku')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('sort')
                    ->label('Urutan')
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
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(collect(DocumentCategory::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()])),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draf',
                        'published' => 'Terbit',
                    ]),
            ])
            ->recordActions([
                Action::make('download')
                    ->label('Unduh')
                    ->icon(Heroicon::ArrowDownTray)
                    ->url(fn (Document $record) => $record->url())
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
