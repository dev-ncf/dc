<?php

namespace App\Filament\Resources\InnovationProjectResource\Pages;

use App\Filament\Resources\InnovationProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInnovationProject extends EditRecord
{
    protected static string $resource = InnovationProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
