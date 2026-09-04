<?php

namespace App\Filament\Resources\KnowledgeAreaResource\Pages;

use App\Filament\Resources\KnowledgeAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKnowledgeArea extends EditRecord
{
    protected static string $resource = KnowledgeAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
