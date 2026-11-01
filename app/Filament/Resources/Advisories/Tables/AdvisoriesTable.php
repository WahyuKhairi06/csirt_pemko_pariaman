<?php

namespace App\Filament\Resources\Advisories\Tables;

use App\Enums\Severity;
use App\Models\Advisory;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AdvisoriesTable
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
                TextColumn::make('severity')
                    ->label('Keparahan')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof Severity ? $state->label() : ucfirst($state))
                    ->color(fn ($state) => match ($state instanceof Severity ? $state->value : $state) {
                        'critical' => 'danger',
                        'high' => 'danger',
                        'medium' => 'warning',
                        'low' => 'info',
                        default => 'gray',
                    }),
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
                SelectFilter::make('severity')
                    ->label('Keparahan')
                    ->options(collect(Severity::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])),
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
                    ->url(fn (Advisory $record) => route('preview.advisory', $record->slug))
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
