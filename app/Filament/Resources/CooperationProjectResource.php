<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CooperationProjectResource\Pages;
use App\Models\CooperationProject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CooperationProjectResource extends Resource
{
    protected static ?string $model = CooperationProject::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationGroup = 'Produção Científica';
    protected static ?string $label = 'Projeto de Cooperação';
    protected static ?string $pluralLabel = 'Projetos de Cooperação';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([

                    // COLUNA PRINCIPAL (2 COLUNAS)
                    Forms\Components\Group::make([
                        Forms\Components\Tabs::make('Dados do Projeto de Cooperação')
                            ->tabs([

                                // ABA 1: IDENTIFICAÇÃO E PARCERIA
                                Forms\Components\Tabs\Tab::make('1. Identificação e Parceria')
                                    ->icon('heroicon-o-identification')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Título do Projeto de Cooperação')
                                            ->placeholder('Ex: Fortalecimento das Competências Científicas em Recursos Marinhos')
                                            ->required()
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('code')
                                            ->label('Código / Referência')
                                            ->placeholder('Ex: COOP-UR-2026/02'),

                                        Forms\Components\Select::make('modality')
                                            ->label('Modalidade de Cooperação')
                                            ->options([
                                                'Investigação Científica Conjunta' => 'Investigação Científica Conjunta',
                                                'Mobilidade Académica (Docente/Estudantil)' => 'Mobilidade Académica (Docente/Estudantil)',
                                                'Desenvolvimento Institucional e Infraestrutura' => 'Desenvolvimento Institucional e Infraestrutura',
                                                'Pós-Graduação e Formação Doutoral' => 'Pós-Graduação e Formação Doutoral',
                                                'Capacitação Pedagógica e Curricular' => 'Capacitação Pedagógica e Curricular',
                                                'Extensão Comunitária Internacional' => 'Extensão Comunitária Internacional',
                                                'Outro' => 'Outro',
                                            ])
                                            ->default('Investigação Científica Conjunta')
                                            ->required(),

                                        Forms\Components\TextInput::make('partner_institution')
                                            ->label('Instituição Parceira')
                                            ->placeholder('Ex: Universidade de Coimbra, Fiocruz, DAAD')
                                            ->required(),

                                        Forms\Components\TextInput::make('partner_country')
                                            ->label('País do Parceiro')
                                            ->default('Portugal')
                                            ->required(),

                                        Forms\Components\Select::make('scope')
                                            ->label('Âmbito Territorial')
                                            ->options([
                                                'Nacional' => 'Nacional',
                                                'Internacional (Bilateral)' => 'Internacional (Bilateral)',
                                                'Regional (SADC)' => 'Regional (SADC)',
                                                'Comunidade CPLP' => 'Comunidade CPLP',
                                                'Multilateral / Consórcio' => 'Multilateral / Consórcio',
                                            ])
                                            ->default('Internacional (Bilateral)')
                                            ->required(),

                                        Forms\Components\Select::make('knowledge_area_id')
                                            ->label('Área Científica Geral')
                                            ->relationship('knowledgeArea', 'name')
                                            ->searchable()
                                            ->preload(),
                                    ])->columns(2),

                                // ABA 2: ENQUADRAMENTO E COORDENAÇÃO
                                Forms\Components\Tabs\Tab::make('2. Coordenação e Enquadramento')
                                    ->icon('heroicon-o-user-group')
                                    ->schema([
                                        Forms\Components\Select::make('coordinator_id')
                                            ->label('Coordenador / Ponto Focal UniRovuma')
                                            ->relationship('coordinator', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),

                                        Forms\Components\Select::make('organic_unit_id')
                                            ->label('Faculdade / Extensão Beneficiária')
                                            ->relationship('organicUnit', 'name')
                                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->sigla})")
                                            ->searchable()
                                            ->preload()
                                            ->nullable(),

                                        Forms\Components\TextInput::make('external_coordinator_name')
                                            ->label('Coordenador na Instituição Parceira')
                                            ->placeholder('Ex: Prof. Doutor António Dias'),

                                        Forms\Components\TextInput::make('external_coordinator_email')
                                            ->label('E-mail do Coordenador Externo')
                                            ->email(),

                                        Forms\Components\Textarea::make('abstract')
                                            ->label('Resumo e Objetivos do Projeto')
                                            ->rows(4)
                                            ->required()
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('expected_results')
                                            ->label('Resultados e Entregáveis Esperados')
                                            ->placeholder('Ex: Publicação de 3 artigos conjuntos, intercâmbio de 2 docentes, instalação de equipamento laboratorial...')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ])->columns(2),

                                // ABA 3: FINANCIAMENTO E FICHEIRO
                                Forms\Components\Tabs\Tab::make('3. Cronograma e Financiamento')
                                    ->icon('heroicon-o-banknotes')
                                    ->schema([
                                        Forms\Components\DatePicker::make('start_date')
                                            ->label('Data de Início'),

                                        Forms\Components\DatePicker::make('end_date')
                                            ->label('Data de Término Prevista'),

                                        Forms\Components\TextInput::make('funding_agency')
                                            ->label('Agência / Entidade Financiadora')
                                            ->placeholder('Ex: Erasmus+, DAAD, FNI, Embaixada da França')
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('budget')
                                            ->label('Orçamento Global')
                                            ->numeric(),

                                        Forms\Components\Select::make('currency')
                                            ->label('Moeda')
                                            ->options([
                                                'MZN' => 'MZN (Metical)',
                                                'USD' => 'USD (Dólar)',
                                                'EUR' => 'EUR (Euro)',
                                            ])
                                            ->default('MZN'),

                                        Forms\Components\FileUpload::make('document_path')
                                            ->label('Documento da Proposta / Acordo de Financiamento (PDF)')
                                            ->directory('cooperation-projects/docs')
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->maxSize(20480)
                                            ->columnSpanFull(),
                                    ])->columns(2),

                            ])
                    ])->columnSpan(2),

                    // COLUNA LATERAL ADMINISTRATIVA (1 COLUNA)
                    Forms\Components\Group::make([
                        Forms\Components\Section::make('Gestão Institucional')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Estado do Projeto')
                                    ->options([
                                        'proposal' => 'Em Elaboração / Negociação',
                                        'approved' => 'Aprovado',
                                        'in_progress' => 'Em Execução',
                                        'completed' => 'Concluído',
                                        'suspended' => 'Suspenso',
                                        'canceled' => 'Cancelado',
                                    ])
                                    ->default('in_progress')
                                    ->required(),

                                Forms\Components\Toggle::make('is_public')
                                    ->label('Visível no Portal Público')
                                    ->helperText('Apresentar na vitrine de Cooperação da UniRovuma.')
                                    ->default(true)
                                    ->onColor('success'),

                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Registado em')
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
                    ->label('Projeto')
                    ->limit(35)
                    ->tooltip(fn ($record) => $record->title)
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('partner_institution')
                    ->label('Parceiro')
                    ->description(fn (CooperationProject $record) => "{$record->partner_country} ({$record->scope})")
                    ->searchable(),

                Tables\Columns\TextColumn::make('coordinator.name')
                    ->label('Ponto Focal UniRovuma')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('organicUnit.sigla')
                    ->label('Unidade')
                    ->badge()
                    ->color('info')
                    ->default('UniRovuma'),

                Tables\Columns\TextColumn::make('modality')
                    ->label('Modalidade')
                    ->badge()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'proposal' => 'Em Negociação',
                        'approved' => 'Aprovado',
                        'in_progress' => 'Em Execução',
                        'completed' => 'Concluído',
                        'suspended' => 'Suspenso',
                        'canceled' => 'Cancelado',
                        default => $state,
                    })
                    ->colors([
                        'warning' => 'proposal',
                        'info' => 'approved',
                        'primary' => 'in_progress',
                        'success' => 'completed',
                        'danger' => ['suspended', 'canceled'],
                    ]),

                Tables\Columns\IconColumn::make('is_public')
                    ->label('Público')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado do Projeto')
                    ->options([
                        'in_progress' => 'Em Execução',
                        'approved' => 'Aprovado',
                        'completed' => 'Concluído',
                        'proposal' => 'Em Negociação',
                    ]),

                Tables\Filters\SelectFilter::make('scope')
                    ->label('Âmbito')
                    ->options([
                        'Nacional' => 'Nacional',
                        'Internacional (Bilateral)' => 'Internacional (Bilateral)',
                        'Regional (SADC)' => 'Regional (SADC)',
                        'Comunidade CPLP' => 'Comunidade CPLP',
                        'Multilateral / Consórcio' => 'Multilateral / Consórcio',
                    ]),

                Tables\Filters\SelectFilter::make('organic_unit_id')
                    ->relationship('organicUnit', 'sigla')
                    ->label('Unidade Orgânica'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('download_doc')
                    ->label('Baixar PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (CooperationProject $record) => asset($record->document_path))
                    ->openUrlInNewTab()
                    ->visible(fn (CooperationProject $record) => filled($record->document_path)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCooperationProjects::route('/'),
            'create' => Pages\CreateCooperationProject::route('/create'),
            'edit' => Pages\EditCooperationProject::route('/{record}/edit'),
        ];
    }
}