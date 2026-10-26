<?php

namespace App\Filament\Resources\PublicationResource\Pages;

use App\Filament\Resources\PublicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublication extends EditRecord
{
    protected static string $resource = PublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
     protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = auth()->id();
         foreach ($data as $key => $value) {
            
            if (is_array($value) && $key !== 'keywords') {
                $data[$key] = json_encode($value); 
            }
        }

        return $data;
    }
}
