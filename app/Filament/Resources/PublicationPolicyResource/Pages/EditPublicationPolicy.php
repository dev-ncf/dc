<?php

namespace App\Filament\Resources\PublicationPolicyResource\Pages;

use App\Filament\Resources\PublicationPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublicationPolicy extends EditRecord
{
    protected static string $resource = PublicationPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
