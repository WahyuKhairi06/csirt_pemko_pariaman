<?php

namespace App\Filament\Resources\PortalLinks\Tables;

use App\Models\PortalLink;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PortalLinksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Nama Portal')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('url')
                    ->label('Alamat URL')
                    ->limit(40)
                    ->color('gray'),
                TextColumn::make('icon')
                    ->label('Ikon')
                    ->badge()
                    ->color('gray'),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->trueIcon(Heroicon::CheckCircle)
                    ->falseIcon(Heroicon::XCircle)
                    ->alignCenter(),
                TextColumn::make('sort')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->recordActions([
                Action::make('visit')
                    ->label('Buka')
                    ->icon(Heroicon::ArrowTopRightOnSquare)
                    ->url(fn (PortalLink $record) => $record->url)
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
