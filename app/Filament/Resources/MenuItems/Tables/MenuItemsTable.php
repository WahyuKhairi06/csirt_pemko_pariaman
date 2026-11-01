<?php

namespace App\Filament\Resources\MenuItems\Tables;

use App\Enums\MenuLocation;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MenuItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')
                    ->label('Label')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof MenuLocation ? ($state === MenuLocation::Header ? 'Header' : 'Footer') : ucfirst($state)),
                TextColumn::make('parent.label')
                    ->label('Menu Induk')
                    ->placeholder('—'),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn ($state) => $state === 'page' ? 'Halaman' : 'URL Kustom'),
                TextColumn::make('sort')
                    ->label('Urutan')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon(Heroicon::CheckCircle)
                    ->falseIcon(Heroicon::XCircle)
                    ->alignCenter(),
            ])
            ->filters([
                SelectFilter::make('location')
                    ->label('Lokasi')
                    ->options([
                        'header' => 'Header Navigasi',
                        'footer' => 'Footer',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->recordActions([
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
