<?php

namespace App\Filament\Resources\InnovationProjectResource\Pages;

use App\Filament\Resources\InnovationProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInnovationProjects extends ListRecords
{
    protected static string $resource = InnovationProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
