<?php

namespace App\Filament\Resources\ResearchPolicyResource\Pages;

use App\Filament\Resources\ResearchPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResearchPolicy extends EditRecord
{
    protected static string $resource = ResearchPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
