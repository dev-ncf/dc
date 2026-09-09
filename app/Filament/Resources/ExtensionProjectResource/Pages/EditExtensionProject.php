<?php

namespace App\Filament\Resources\ExtensionProjectResource\Pages;

use App\Filament\Resources\ExtensionProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtensionProject extends EditRecord
{
    protected static string $resource = ExtensionProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
