<?php

namespace App\Filament\Resources\CooperationAgreementResource\Pages;

use App\Filament\Resources\CooperationAgreementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCooperationAgreement extends EditRecord
{
    protected static string $resource = CooperationAgreementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
