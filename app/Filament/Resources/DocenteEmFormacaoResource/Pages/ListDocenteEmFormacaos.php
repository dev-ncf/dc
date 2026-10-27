<?php

namespace App\Filament\Resources\DocenteEmFormacaoResource\Pages;

use App\Filament\Resources\DocenteEmFormacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocenteEmFormacaos extends ListRecords
{
    protected static string $resource = DocenteEmFormacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
