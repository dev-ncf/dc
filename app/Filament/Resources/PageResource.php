<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use App\Models\Menu;
use Filament\Forms\Components\Select;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    
    protected static ?string $navigationGroup = 'Configuração do Portal';
    
    protected static ?string $label = 'Página Institucional';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    // COLUNA PRINCIPAL (CONTEÚDO)
                    Section::make('Conteúdo da Página')
                        ->schema([
                            TextInput::make('title')
                                ->label('Título da Página')
                                ->required()
                                ->live(onBlur: true) // Gera o slug quando o utilizador sai do campo
                                ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                    $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                ->maxLength(255),

                            TextInput::make('slug')
                                ->label('Caminho URL (Slug)')
                                ->required()
                                ->unique(Page::class, 'slug', ignoreRecord: true)
                                ->helperText('O endereço será: seusite.com/pagina/seu-slug'),

                            RichEditor::make('content')
                                ->label('Corpo da Página')
                                ->required()
                                ->fileAttachmentsDirectory('pages/attachments') // Permite upload de imagens no texto
                                ->columnSpanFull(),
                        ])->columnSpan(2),

                    // COLUNA LATERAL (METADADOS E STATUS)
                    Forms\Components\Group::make()->schema([
                        Section::make('Configurações')
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Página Publicada')
                                    ->default(true)
                                    ->onColor('success'),
                                
                                FileUpload::make('featured_image')
                                    ->label('Imagem de Capa')
                                    ->directory('pages/covers')
                                    ->image()
                                    ->imageEditor(),
                            ]),
                        
                        Section::make('SEO (Opcional)')
                            ->description('Melhore a visibilidade no Google')
                            ->schema([
                                TextInput::make('meta_description')
                                    ->label('Descrição curta')
                                    ->placeholder('Resumo para motores de busca...')
                                    ->maxLength(160),
                            ]),

                            Section::make('Vínculo Obrigatório com o Menu')
                                ->description('Toda página deve estar associada a um item de menu.')
                                ->schema([
                                    Forms\Components\Radio::make('menu_action')
                                        ->label('Como deseja vincular esta página?')
                                        ->options([
                                            'existing' => 'Vincular a um menu já existente',
                                            'new' => 'Criar um novo item no menu',
                                        ])
                                        ->default('new')
                                        ->live()
                                        ->required()
                                        ->dehydrated(false),

                                    Grid::make(2)->schema([
                                        // Se escolher EXISTENTE
                                        Select::make('existing_menu_id')
                                            ->label('Selecione o Menu')
                                            ->options(Menu::all()->pluck('label', 'id'))
                                            ->searchable()
                                            ->required(fn ($get) => $get('menu_action') === 'existing')
                                            ->visible(fn ($get) => $get('menu_action') === 'existing')
                                            ->dehydrated(false)
                                            ->helperText('O link deste menu será alterado para esta página.'),

                                        // Se escolher NOVO
                                        TextInput::make('menu_label')
                                            ->label('Rótulo do Novo Menu')
                                            ->required(fn ($get) => $get('menu_action') === 'new')
                                            ->visible(fn ($get) => $get('menu_action') === 'new')
                                            ->dehydrated(false),

                                        Select::make('menu_parent_id')
                                            ->label('Menu Pai (Opcional)')
                                            ->options(Menu::whereNull('parent_id')->pluck('label', 'id'))
                                            ->visible(fn ($get) => $get('menu_action') === 'new')
                                            ->dehydrated(false),

                                        Select::make('menu_type')
                                            ->label('Localização')
                                            ->options(['header' => 'Superior', 'footer' => 'Rodapé'])
                                            ->default('header')
                                            ->visible(fn ($get) => $get('menu_action') === 'new')
                                            ->dehydrated(false),
                                    ]),
                                ]),

                        Section::make('Auditoria')
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Criada em')
                                    ->content(fn (?Page $record): string => $record ? $record->created_at->diffForHumans() : '-'),
                                
                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Última atualização')
                                    ->content(fn (?Page $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                            ])->hidden(fn (?Page $record) => $record === null),
                    ])->columnSpan(1),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Capa')
                    ->circular(),

                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label('Link/Slug')
                    ->color('gray')
                    ->icon('heroicon-o-link'),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Criada em')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status de Publicação'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    // Ação para visualizar a página no site real
                    Tables\Actions\Action::make('view_live')
                        ->label('Ver no Site')
                        ->icon('heroicon-o-arrow-top-right-on-square')
                        ->color('info')
                        ->url(fn (Page $record): string => "/pagina/{$record->slug}")
                        ->openUrlInNewTab(),
                ]),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}