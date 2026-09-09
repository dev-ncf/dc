<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InnovationProjectResource\Pages;
use App\Filament\Resources\InnovationProjectResource\RelationManagers;
use App\Models\InnovationProject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InnovationProjectResource extends Resource
{
    protected static ?string $model = InnovationProject::class;
    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';
    protected static ?string $navigationGroup = 'Produção Científica';
    protected static ?string $label = 'Projeto de Inovação';
    protected static ?string $pluralLabel = 'Projetos de Inovação';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    
                    // COLUNA ESQUERDA (WIZARD)
                    Forms\Components\Group::make([
                        Forms\Components\Wizard::make([
                            
                            // PASSO 1
                            Forms\Components\Wizard\Step::make('Identificação da Inovação')
                                ->icon('heroicon-o-sparkles')
                                ->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->label('Título da Inovação / Protótipo')
                                        ->required()
                                        ->columnSpanFull(),
                                        
                                    Forms\Components\Select::make('inventor_id')
                                        ->label('Inventor / Criador Principal')
                                        ->relationship('inventor', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required(),

                                    Forms\Components\Select::make('knowledge_area_id')
                                        ->label('Área Científica / Tecnológica')
                                        ->relationship('knowledgeArea', 'name')
                                        ->required(),

                                    Forms\Components\Select::make('innovation_type')
                                        ->label('Categoria da Inovação')
                                        ->options([
                                            'prototipo_tecnologico' => 'Protótipo Tecnológico / Hardware',
                                            'produto_alimentar' => 'Processamento Agroalimentar / Bioproproduto',
                                            'software' => 'Software / Aplicativo Digital',
                                            'patente' => 'Registo de Patente / Propriedade Intelectual',
                                        ])
                                        ->required(),

                                    Forms\Components\Select::make('trl_level')
                                        ->label('Nível de Maturidade (TRL)')
                                        ->options([
                                            'trl_1_3' => 'TRL 1-3: Conceito / Pesquisa Básica',
                                            'trl_4_6' => 'TRL 4-6: Protótipo / Teste em Laboratório',
                                            'trl_7_9' => 'TRL 7-9: Pronto para o Mercado / Comercializável',
                                        ])
                                        ->required(),
                                ])->columns(2),

                            // PASSO 2
                            Forms\Components\Wizard\Step::make('Mercado e Documentação')
                                ->icon('heroicon-o-presentation-chart-line')
                                ->schema([
                                    Forms\Components\Textarea::make('abstract')
                                        ->label('Descrição / Resumo Técnico')
                                        ->required()
                                        ->rows(4)
                                        ->columnSpanFull(),

                                    Forms\Components\Textarea::make('market_potential')
                                        ->label('Potencial de Mercado e Aplicabilidade')
                                        ->helperText('Como este produto resolve um problema real da sociedade ou mercado?')
                                        ->rows(3)
                                        ->columnSpanFull(),

                                    // Protegido contra o erro do PDF na edição
                                    Forms\Components\FileUpload::make('project_file_path')
                                        ->label('Pitch Deck / Documentação Técnica (PDF)')
                                        ->directory('innovation-projects/docs')
                                        ->acceptedFileTypes(['application/pdf'])
                                        ->required(fn (string $operation): bool => $operation === 'create')
                                        ->dehydrateStateUsing(fn ($state, ?InnovationProject $record) => $state ?? $record?->project_file_path)
                                        ->columnSpanFull(),
                                ]),
                        ])
                    ])->columnSpan(2),

                    // COLUNA DIREITA (ESTADO)
                    Forms\Components\Group::make([
                        Forms\Components\Section::make('Incubação & Gestão')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Estado da Inovação')
                                    ->options([
                                        'pending' => 'Pendente de Avaliação',
                                        'incubating' => 'Em Incubação (Startups)',
                                        'market_ready' => 'Pronto para o Mercado',
                                        'patented' => 'Patenteado / Registado',
                                        'rejected' => 'Rejeitado',
                                    ])
                                    ->default('pending')
                                    ->required()
                                    ->native(false),

                                Forms\Components\Toggle::make('is_public')
                                    ->label('Vitrine de Inovação (Público)')
                                    ->default(true)
                                    ->onColor('success'),
                            ])
                    ])->columnSpan(1),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Inovação')->searchable()->limit(30),
                Tables\Columns\TextColumn::make('innovation_type')->label('Tipo')->badge(),
                Tables\Columns\TextColumn::make('trl_level')->label('Maturidade')->badge()->color('info'),
                Tables\Columns\TextColumn::make('status')->badge()->colors([
                    'warning' => 'pending',
                    'primary' => 'incubating',
                    'success' => ['market_ready', 'patented'],
                    'danger' => 'rejected',
                ]),
                Tables\Columns\IconColumn::make('is_public')->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInnovationProjects::route('/'),
            'create' => Pages\CreateInnovationProject::route('/create'),
            'edit' => Pages\EditInnovationProject::route('/{record}/edit'),
        ];
    }
}