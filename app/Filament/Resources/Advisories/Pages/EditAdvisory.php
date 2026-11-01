<?php

namespace App\Filament\Resources\Advisories\Pages;

use App\Filament\Resources\Advisories\AdvisoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdvisory extends EditRecord
{
    protected static string $resource = AdvisoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
