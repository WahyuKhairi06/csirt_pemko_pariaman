<?php

namespace App\Filament\Resources\Advisories\Pages;

use App\Filament\Resources\Advisories\AdvisoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdvisories extends ListRecords
{
    protected static string $resource = AdvisoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
