<?php

namespace App\Filament\Resources\CooperationAgreementResource\Pages;

use App\Filament\Resources\CooperationAgreementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCooperationAgreements extends ListRecords
{
    protected static string $resource = CooperationAgreementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
