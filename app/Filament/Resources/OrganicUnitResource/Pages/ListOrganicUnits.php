<?php

namespace App\Filament\Resources\OrganicUnitResource\Pages;

use App\Filament\Resources\OrganicUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrganicUnits extends ListRecords
{
    protected static string $resource = OrganicUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
