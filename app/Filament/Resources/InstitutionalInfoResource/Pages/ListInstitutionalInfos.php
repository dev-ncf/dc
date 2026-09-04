<?php

namespace App\Filament\Resources\InstitutionalInfoResource\Pages;

use App\Filament\Resources\InstitutionalInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInstitutionalInfos extends ListRecords
{
    protected static string $resource = InstitutionalInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
