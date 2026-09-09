<?php

namespace App\Filament\Resources\ExtensionProjectResource\Pages;

use App\Filament\Resources\ExtensionProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtensionProjects extends ListRecords
{
    protected static string $resource = ExtensionProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
