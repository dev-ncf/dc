<?php

namespace App\Filament\Resources\OrganicUnitResource\Pages;

use App\Filament\Resources\OrganicUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganicUnit extends EditRecord
{
    protected static string $resource = OrganicUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
