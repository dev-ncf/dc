<?php

namespace App\Filament\Resources\ResearchPolicyResource\Pages;

use App\Filament\Resources\ResearchPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResearchPolicies extends ListRecords
{
    protected static string $resource = ResearchPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
