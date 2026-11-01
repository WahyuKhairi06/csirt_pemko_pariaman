<?php

namespace App\Filament\Resources\PortalLinks;

use App\Filament\Resources\PortalLinks\Pages\CreatePortalLink;
use App\Filament\Resources\PortalLinks\Pages\EditPortalLink;
use App\Filament\Resources\PortalLinks\Pages\ListPortalLinks;
use App\Filament\Resources\PortalLinks\Schemas\PortalLinkForm;
use App\Filament\Resources\PortalLinks\Tables\PortalLinksTable;
use App\Models\PortalLink;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PortalLinkResource extends Resource
{
    protected static ?string $model = PortalLink::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::GlobeAlt;

    protected static string|UnitEnum|null $navigationGroup = 'Navigasi & Sistem';

    protected static ?string $navigationLabel = 'Portal Layanan';

    protected static ?string $modelLabel = 'Tautan Portal';

    protected static ?string $pluralModelLabel = 'Portal Layanan';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return PortalLinkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PortalLinksTable::configure($table);
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
            'index' => ListPortalLinks::route('/'),
            'create' => CreatePortalLink::route('/create'),
            'edit' => EditPortalLink::route('/{record}/edit'),
        ];
    }
}
