<?php

namespace App\Filament\Resources\Pages\Tables;

use App\Models\Page;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->color('gray'),
                IconColumn::make('is_home')
                    ->label('Beranda')
                    ->boolean()
                    ->trueIcon(Heroicon::Home)
                    ->falseIcon(Heroicon::Minus)
                    ->alignCenter(),
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
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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
                    ->url(fn (Page $record) => route('preview.page', $record->slug))
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn (Page $record) => ! $record->is_home),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
