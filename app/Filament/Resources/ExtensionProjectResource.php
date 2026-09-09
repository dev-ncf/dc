<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtensionProjectResource\Pages;
use App\Filament\Resources\ExtensionProjectResource\RelationManagers;
use App\Models\ExtensionProject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExtensionProjectResource extends Resource
{
    protected static ?string $model = ExtensionProject::class;
    protected static ?string $navigationIcon = 'heroicon-o-users'; // Ícone focado em comunidade/pessoas
    protected static ?string $navigationGroup = 'Produção Científica';
    protected static ?string $label = 'Projeto de Extensão';
    protected static ?string $pluralLabel = 'Projetos de Extensão';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    
                    // COLUNA DA ESQUERDA (WIZARD - 2 colunas)
                    Forms\Components\Group::make([
                        Forms\Components\Wizard::make([
                            
                            // PASSO 1: IDENTIFICAÇÃO E PARCERIAS
                            Forms\Components\Wizard\Step::make('Identificação')
                                ->icon('heroicon-o-identification')
                                ->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->label('Título do Projeto de Extensão')
                                        ->required()
                                        ->columnSpanFull(),
                                        
                                    Forms\Components\Select::make('coordinator_id')
                                        ->label('Coordenador (Docente/Pesquisador)')
                                        ->relationship('coordinator', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required(),

                                    Forms\Components\TextInput::make('community_partner')
                                        ->label('Parceiro Comunitário / Beneficiário')
                                        ->helperText('Ex: Associação de Agricultores de Mueda, Hospital Central, etc.')
                                        ->required(),

                                    Forms\Components\TextInput::make('target_beneficiaries')
                                        ->label('Público-Alvo')
                                        ->helperText('Ex: 50 Famílias locais, Estudantes do ensino secundário'),

                                    Forms\Components\Select::make('knowledge_area_id')
                                        ->label('Área Temática')
                                        ->relationship('knowledgeArea', 'name')
                                        ->required(),
                                ])->columns(2),

                            // PASSO 2: IMPACTO E DOCUMENTAÇÃO
                            Forms\Components\Wizard\Step::make('Resumo e Impacto')
                                ->icon('heroicon-o-light-bulb')
                                ->schema([
                                    Forms\Components\Textarea::make('abstract')
                                        ->label('Resumo / Objetivos de Extensão')
                                        ->required()
                                        ->rows(4)
                                        ->columnSpanFull(),

                                    Forms\Components\Textarea::make('expected_impact')
                                        ->label('Impacto Social Esperado')
                                        ->rows(3)
                                        ->columnSpanFull(),

                                    // Protegido contra o erro de alteração de PDF na edição
                                    Forms\Components\FileUpload::make('project_file_path')
                                        ->label('Relatório / Proposta de Extensão (PDF)')
                                        ->directory('extension-projects/docs')
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->required(fn (string $operation): bool => $operation === 'create')
                                        ->dehydrateStateUsing(fn ($state, ?ExtensionProject $record) => $state ?? $record?->project_file_path)
                                        ->columnSpanFull(),
                                ]),

                            // PASSO 3: CRONOGRAMA E ORÇAMENTO
                            Forms\Components\Wizard\Step::make('Cronograma e Financiamento')
                                ->icon('heroicon-o-calendar')
                                ->schema([
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\DatePicker::make('start_date')->label('Data de Início'),
                                        Forms\Components\DatePicker::make('end_date')->label('Data de Término Prevista'),
                                    ]),
                                    Forms\Components\TextInput::make('requested_budget')
                                        ->label('Orçamento / Custo Estimado')
                                        ->numeric()
                                        ->prefix('MZN'),
                                    Forms\Components\TextInput::make('funding_source')
                                        ->label('Fonte de Financiamento / Apoio Institucional'),
                                ]),
                        ])
                    ])->columnSpan(2),

                    // COLUNA DA DIREITA (CONTROLE ADMINISTRATIVO - 1 coluna)
                    Forms\Components\Group::make([
                        Forms\Components\Section::make('Controle Administrativo')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Estado do Projeto')
                                    ->options([
                                        'pending' => 'Pendente',
                                        'approved' => 'Aprovado',
                                        'in_execution' => 'Em Execução',
                                        'completed' => 'Concluído',
                                        'suspended' => 'Suspenso',
                                        'rejected' => 'Rejeitado',
                                    ])
                                    ->default('pending')
                                    ->required()
                                    ->native(false),

                                Forms\Components\Toggle::make('is_public')
                                    ->label('Visível no Portal')
                                    ->helperText('Publicar na vitrine de extensão universitária.')
                                    ->default(true)
                                    ->onColor('success'),

                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Criado em')
                                    ->content(fn ($record) => $record?->created_at?->format('d/m/Y H:i') ?? 'Agora'),
                            ])
                    ])->columnSpan(1),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->limit(30)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('community_partner')
                    ->label('Parceiro Comunitário')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pendente',
                        'approved' => 'Aprovado',
                        'in_execution' => 'Em Execução',
                        'completed' => 'Concluído',
                        'suspended' => 'Suspenso',
                        'rejected' => 'Rejeitado',
                        default => $state,
                    })
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'approved',
                        'primary' => 'in_execution',
                        'success' => 'completed',
                        'danger' => ['rejected', 'suspended'],
                    ]),

                Tables\Columns\IconColumn::make('is_public')
                    ->label('Público')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    
                    Tables\Actions\Action::make('download')
                        ->label('Baixar Documento')
                        ->icon('heroicon-o-document-arrow-down')
                        ->url(fn ($record) => asset($record->project_file_path))
                        ->openUrlInNewTab()
                        ->visible(fn ($record) => filled($record->project_file_path)),
                ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'in_execution' => 'Em Execução',
                        'completed' => 'Concluído',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExtensionProjects::route('/'),
            'create' => Pages\CreateExtensionProject::route('/create'),
            'edit' => Pages\EditExtensionProject::route('/{record}/edit'),
        ];
    }
}