<?php

namespace App\Filament\Resources\ResearchLineResource\Pages;

use App\Filament\Resources\ResearchLineResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResearchLine extends EditRecord
{
    protected static string $resource = ResearchLineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
