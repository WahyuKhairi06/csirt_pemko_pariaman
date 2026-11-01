<?php

namespace App\Filament\Resources\Services\Tables;

use App\Enums\ServiceGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Layanan')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('group')
                    ->label('Kelompok')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof ServiceGroup ? $state->label() : ucfirst($state)),
                TextColumn::make('response_target')
                    ->label('Target SLA'),
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
                SelectFilter::make('group')
                    ->label('Kelompok')
                    ->options(collect(ServiceGroup::cases())->mapWithKeys(fn ($g) => [$g->value => $g->label()])),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draf',
                        'published' => 'Terbit',
                    ]),
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
