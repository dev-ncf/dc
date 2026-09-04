<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Models\Menu;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function afterSave(): void
    {
        $data = $this->form->getRawState();
        $page = $this->record;
        
        // Caminho antigo e novo
        $oldPath = "/pagina/" . $page->getOriginal('slug');
        $newPath = "/pagina/" . $page->slug;

        // 1. Sincronização automática do SLUG no Menu
        // Se o slug mudou, procuramos qualquer menu que aponte para o link antigo e atualizamos
        Menu::where('url', $oldPath)->update(['url' => $newPath]);

        // 2. Lógica de alteração de vínculo (se o user mudar o rádio na edição)
        if ($data['menu_action'] === 'existing' && !empty($data['existing_menu_id'])) {
            Menu::find($data['existing_menu_id'])->update(['url' => $newPath]);
        } 
        elseif ($data['menu_action'] === 'new' && !empty($data['menu_label'])) {
            // Verifica se este rótulo já existe para evitar duplicados ou cria
            Menu::updateOrCreate(
                ['url' => $newPath],
                [
                    'label' => $data['menu_label'],
                    'parent_id' => $data['menu_parent_id'],
                    'type' => $data['menu_type'],
                ]
            );
        }
    }
}