<?php

namespace App\Filament\Resources\Advisories;

use App\Filament\Resources\Advisories\Pages\CreateAdvisory;
use App\Filament\Resources\Advisories\Pages\EditAdvisory;
use App\Filament\Resources\Advisories\Pages\ListAdvisories;
use App\Filament\Resources\Advisories\Schemas\AdvisoryForm;
use App\Filament\Resources\Advisories\Tables\AdvisoriesTable;
use App\Models\Advisory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AdvisoryResource extends Resource
{
    protected static ?string $model = Advisory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ExclamationTriangle;

    protected static string|UnitEnum|null $navigationGroup = 'Operasional Keamanan';

    protected static ?string $navigationLabel = 'Advisori Keamanan';

    protected static ?string $modelLabel = 'Advisori';

    protected static ?string $pluralModelLabel = 'Advisori Keamanan';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return AdvisoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdvisoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdvisories::route('/'),
            'create' => CreateAdvisory::route('/create'),
            'edit' => EditAdvisory::route('/{record}/edit'),
        ];
    }
}
