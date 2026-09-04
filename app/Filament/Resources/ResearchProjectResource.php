<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResearchProjectResource\Pages;
use App\Models\ResearchProject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ResearchProjectResource extends Resource
{
    protected static ?string $model = ResearchProject::class;
    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Produção Científica';
    protected static ?string $label = 'Projeto de Pesquisa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Usamos um Grid para colocar o controle de status na lateral em telas grandes
                Forms\Components\Grid::make(3)->schema([
                    
                    // COLUNA DA ESQUERDA (WIZARD - 2 colunas)
                    Forms\Components\Group::make([
                        Forms\Components\Wizard::make([
                            // PASSO 1: IDENTIFICAÇÃO
                            Forms\Components\Wizard\Step::make('Identificação')
                                ->icon('heroicon-o-information-circle')
                                ->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->label('Título do Projeto')
                                        ->required()
                                        ->columnSpanFull(),
                                    Forms\Components\Select::make('coordinator_id')
                                        ->label('Coordenador Principal')
                                        ->relationship('coordinator', 'name')
                                        ->searchable()
                                        ->preload(),
                                    Forms\Components\Select::make('knowledge_area_id')
                                        ->label('Área Científica')
                                        ->relationship('knowledgeArea', 'name')
                                        ->required(),
                                ])->columns(2),

                            // PASSO 2: DETALHES TÉCNICOS
                            Forms\Components\Wizard\Step::make('Resumo e Documentação')
                                ->icon('heroicon-o-document-plus')
                                ->schema([
                                    Forms\Components\Textarea::make('abstract')
                                        ->label('Resumo Executivo')
                                        ->required()
                                        ->rows(5)
                                        ->columnSpanFull(),
                                    Forms\Components\FileUpload::make('project_file_path')
                                        ->label('Proposta Técnica (PDF)')
                                        ->directory('projects/docs')
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->required(),
                                ]),

                            // PASSO 3: PLANEAMENTO
                            Forms\Components\Wizard\Step::make('Planeamento')
                                ->icon('heroicon-o-currency-dollar')
                                ->schema([
                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\DatePicker::make('start_date')->label('Data Início'),
                                        Forms\Components\DatePicker::make('end_date')->label('Data Fim previsto'),
                                    ]),
                                    Forms\Components\TextInput::make('requested_budget')
                                        ->label('Orçamento Solicitado')
                                        ->numeric()
                                        ->prefix('MZN'),
                                    Forms\Components\TextInput::make('funding_agency')
                                        ->label('Entidade Financiadora'),
                                ]),
                        ])
                    ])->columnSpan(2),

                    // COLUNA DA DIREITA (CONTROLE DE STATUS - 1 coluna)
                    Forms\Components\Group::make([
                        Forms\Components\Section::make('Controle Administrativo')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Estado do Projeto')
                                    ->options([
                                        'pending_validation' => 'Pendente',
                                        'searching_funds' => 'Busca Financiamento',
                                        'portfolio' => 'Na Carteira',
                                        'funded' => 'Financiado',
                                        'in_execution' => 'Em Execução',
                                        'completed' => 'Concluído',
                                        'rejected' => 'Rejeitado',
                                    ])
                                    ->required()
                                    ->native(false),

                                Forms\Components\Toggle::make('is_public')
                                    ->label('Visível no Site')
                                    ->helperText('Define se o público pode ver este projeto.')
                                    ->onColor('success'),

                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Submetido em')
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
                    ->limit(35)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending_validation' => 'Pendente',
                        'searching_funds' => 'Busca Financiamento',
                        'portfolio' => 'Na Carteira',
                        'funded' => 'Financiado',
                        'in_execution' => 'Em Execução',
                        'completed' => 'Concluído',
                        'rejected' => 'Rejeitado',
                        default => $state,
                    })
                    ->colors([
                        'gray' => 'pending_validation',
                        'warning' => 'searching_funds',
                        'info' => 'portfolio',
                        'success' => ['funded', 'completed'],
                        'primary' => 'in_execution',
                        'danger' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('requested_budget')
                    ->label('Orçamento')
                    ->money('MZN'),

                Tables\Columns\IconColumn::make('is_public')
                    ->label('Público')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    
                    // AÇÃO PARA MUDAR STATUS RAPIDAMENTE
                    Tables\Actions\Action::make('updateStatus')
                        ->label('Alterar Status')
                        ->icon('heroicon-o-arrow-path')
                        ->color('info')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('Novo Estado')
                                ->options([
                                    'pending_validation' => 'Pendente',
                                    'searching_funds' => 'Busca Financiamento',
                                    'portfolio' => 'Na Carteira',
                                    'funded' => 'Financiado',
                                    'in_execution' => 'Em Execução',
                                    'completed' => 'Concluído',
                                    'rejected' => 'Rejeitado',
                                ])
                                ->required(),
                        ])
                        ->action(function (ResearchProject $record, array $data): void {
                            $record->update(['status' => $data['status']]);
                        }),

                    Tables\Actions\Action::make('download')
                        ->label('Baixar PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->url(fn ($record) => asset('' . $record->project_file_path))
                        ->openUrlInNewTab(),
                ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending_validation' => 'Pendente',
                        'in_execution' => 'Em Execução',
                        'portfolio' => 'Carteira',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResearchProjects::route('/'),
            'create' => Pages\CreateResearchProject::route('/create'),
            'edit' => Pages\EditResearchProject::route('/{record}/edit'),
        ];
    }
}