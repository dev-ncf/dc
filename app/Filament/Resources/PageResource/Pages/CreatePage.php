<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Models\Menu;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function afterCreate(): void
    {
        $data = $this->form->getRawState();
        $slugPath = "/pagina/{$this->record->slug}";

        if ($data['menu_action'] === 'existing') {
            // Atualiza o menu escolhido para apontar para a nova página
            Menu::find($data['existing_menu_id'])->update([
                'url' => $slugPath,
                'is_visible' => true
            ]);
        } else {
            // Cria um novo item de menu
            Menu::create([
                'label' => $data['menu_label'],
                'url' => $slugPath,
                'parent_id' => $data['menu_parent_id'],
                'type' => $data['menu_type'],
                'is_visible' => true,
                'sort' => 0,
            ]);
        }
    }
}