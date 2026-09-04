<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    
    protected static ?string $navigationGroup = 'Configuração do Portal';
    
    protected static ?string $label = 'Menu Dinâmico';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Estrutura do Menu')
                    ->description('Defina o nome, a hierarquia e o destino deste item de menu.')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('label')
                                ->label('Rótulo (Nome visível)')
                                ->required()
                                ->placeholder('Ex: Sobre a UEM, Ensino, Investigação')
                                ->maxLength(255),

                            Select::make('parent_id')
                                ->label('Menu Pai')
                                ->relationship('parent', 'label')
                                ->searchable()
                                ->preload()
                                ->placeholder('Nenhum (Este será um item principal)'),
                        ]),

                        TextInput::make('url')
                            ->label('URL ou Rota')
                            ->required()
                            ->placeholder('Ex: /investigacao ou https://google.com')
                            ->helperText('Use "/" para a página inicial, links relativos para páginas internas ou links completos para sites externos.'),

                        Grid::make(3)->schema([
                            Select::make('type')
                                ->label('Localização')
                                ->options([
                                    'header' => 'Menu Superior (Principal)',
                                    'footer' => 'Rodapé (Institucional)',
                                    'quick_links' => 'Links Rápidos (Sidebar)',
                                ])
                                ->default('header')
                                ->required(),

                            TextInput::make('sort')
                                ->label('Ordem de Exibição')
                                ->numeric()
                                ->default(0)
                                ->helperText('Números menores aparecem primeiro.'),

                            Toggle::make('is_external')
                                ->label('Abrir em nova aba?')
                                ->inline(false),
                        ]),
                        
                        Toggle::make('is_visible')
                            ->label('Menu Ativo/Visível')
                            ->default(true)
                            ->onColor('success'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('parent.label')
                    ->label('Superior')
                    ->placeholder('Principal')
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->colors([
                        'primary' => 'header',
                        'warning' => 'footer',
                        'success' => 'quick_links',
                    ]),

                TextColumn::make('sort')
                    ->label('Ordem')
                    ->sortable(),

                IconColumn::make('is_visible')
                    ->label('Status')
                    ->boolean(),

                TextColumn::make('url')
                    ->label('Destino')
                    ->limit(30)
                    ->color('gray'),
            ])
            ->defaultSort('sort', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Filtrar por Localização')
                    ->options([
                        'header' => 'Header',
                        'footer' => 'Footer',
                        'quick_links' => 'Links Rápidos',
                    ]),
                
                Tables\Filters\TernaryFilter::make('is_visible')
                    ->label('Apenas visíveis')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Se você quiser gerir submenus diretamente de dentro do menu pai, 
            // podemos adicionar um RelationManager aqui no futuro.
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}