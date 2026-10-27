<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CooperationAgreementResource\Pages;
use App\Models\CooperationAgreement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CooperationAgreementResource extends Resource
{
    protected static ?string $model = CooperationAgreement::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Cooperação';
    protected static ?string $label = 'Acordo de Cooperação';
    protected static ?string $pluralLabel = 'Acordos e Protocolos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Instrumento de Cooperação')
                    ->tabs([

                        // ABA 1: IDENTIFICAÇÃO E PARCEIRO
                        Forms\Components\Tabs\Tab::make('1. Parceria e Identificação')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Título do Acordo / Protocolo')
                                    ->placeholder('Ex: Acordo Geral de Cooperação Académica e Científica')
                                    ->required()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('agreement_number')
                                    ->label('N.º de Registo / Protocolo')
                                    ->placeholder('Ex: AC/UR/2026/01')
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                Forms\Components\Select::make('type')
                                    ->label('Tipo de Instrumento')
                                    ->options([
                                        'Memorando de Entendimento (MoU)' => 'Memorando de Entendimento (MoU)',
                                        'Acordo-Quadro' => 'Acordo-Quadro',
                                        'Protocolo Específico' => 'Protocolo Específico',
                                        'Convénio de Estágio' => 'Convénio de Estágio',
                                        'Carta de Intenções' => 'Carta de Intenções',
                                        'Adenda / Aditivo' => 'Adenda / Aditivo',
                                    ])
                                    ->default('Memorando de Entendimento (MoU)')
                                    ->required(),

                                Forms\Components\TextInput::make('partner_name')
                                    ->label('Instituição Parceira')
                                    ->placeholder('Ex: Universidade de Lisboa, Embaixada do Japão, FNI')
                                    ->required(),

                                Forms\Components\TextInput::make('partner_country')
                                    ->label('País do Parceiro')
                                    ->default('Moçambique')
                                    ->required(),

                                Forms\Components\Select::make('scope')
                                    ->label('Âmbito Territorial')
                                    ->options([
                                        'Nacional' => 'Nacional (Moçambique)',
                                        'Regional (SADC)' => 'Regional (SADC)',
                                        'CPLP' => 'Comunidade CPLP',
                                        'Internacional Geral' => 'Internacional Geral',
                                    ])
                                    ->default('Internacional Geral')
                                    ->required(),
                            ])->columns(2),

                        // ABA 2: VÍNCULO INTERNO E VIGÊNCIA
                        Forms\Components\Tabs\Tab::make('2. Vigência e Responsáveis')
                            ->icon('heroicon-o-calendar')
                            ->schema([
                                Forms\Components\Select::make('organic_unit_id')
                                    ->label('Faculdade / Extensão Beneficiária')
                                    ->relationship('organicUnit', 'name')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->sigla})")
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->helperText('Deixe vazio se for um acordo geral de toda a UniRovuma.'),

                                Forms\Components\Select::make('focal_point_id')
                                    ->label('Ponto Focal UniRovuma (Docente/Diretor)')
                                    ->relationship('focalPoint', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->helperText('Responsável por dinamizar o acordo.'),

                                Forms\Components\DatePicker::make('signature_date')
                                    ->label('Data de Assinatura')
                                    ->default(now())
                                    ->required(),

                                Forms\Components\DatePicker::make('expiration_date')
                                    ->label('Data de Expiração / Validade')
                                    ->helperText('Deixe vazio se for indeterminado.'),

                                Forms\Components\Toggle::make('auto_renew')
                                    ->label('Renovação Automática prevista em cláusula')
                                    ->default(false),

                                Forms\Components\Select::make('status')
                                    ->label('Estado Jurídico')
                                    ->options([
                                        'negotiation' => 'Em Negociação',
                                        'active' => 'Vigente',
                                        'renewing' => 'Em Processo de Renovação',
                                        'expired' => 'Expirado / Caducado',
                                        'terminated' => 'Rescindido',
                                    ])
                                    ->default('active')
                                    ->required(),
                            ])->columns(2),

                        // ABA 3: ÁREAS, OBJETIVOS E ARQUIVO
                        Forms\Components\Tabs\Tab::make('3. Áreas e Ficheiro Assinado')
                            ->icon('heroicon-o-document-arrow-up')
                            ->schema([
                                Forms\Components\CheckboxList::make('areas_of_cooperation')
                                    ->label('Áreas Cobertas pelo Acordo')
                                    ->options([
                                        'Investigação Científica Conjunta' => 'Investigação Científica Conjunta',
                                        'Mobilidade Docente / Investigadores' => 'Mobilidade Docente / Investigadores',
                                        'Mobilidade Estudantil' => 'Mobilidade Estudantil',
                                        'Pós-Graduação e Cotutela' => 'Pós-Graduação e Cotutela',
                                        'Partilha de Laboratórios e Equipamentos' => 'Partilha de Laboratórios e Equipamentos',
                                        'Cursos e Conferências' => 'Cursos e Conferências',
                                        'Estágios Profissionais' => 'Estágios Profissionais',
                                        'Doações e Financiamento' => 'Doações e Financiamento',
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),

                                Forms\Components\Textarea::make('objectives')
                                    ->label('Resumo dos Objetivos do Acordo')
                                    ->rows(3)
                                    ->columnSpanFull(),

                                Forms\Components\FileUpload::make('document_file_path')
                                    ->label('Acordo Assinado Digitalizado (PDF com carimbo e assinaturas)')
                                    ->directory('cooperation-agreements/signed')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->maxSize(20480)
                                    ->columnSpan(2),

                                Forms\Components\Toggle::make('is_public')
                                    ->label('Listar no Portal Público da UniRovuma')
                                    ->default(true),
                            ])->columns(2),

                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('agreement_number')
                    ->label('N.º Registo')
                    ->badge()
                    ->color('gray')
                    ->searchable(),

                Tables\Columns\TextColumn::make('partner_name')
                    ->label('Parceiro')
                    ->description(fn (CooperationAgreement $record) => "{$record->partner_country} • {$record->type}")
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('organicUnit.sigla')
                    ->label('Unidade')
                    ->badge()
                    ->color('info')
                    ->default('UniRovuma'),

                Tables\Columns\TextColumn::make('signature_date')
                    ->label('Assinatura')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('expiration_date')
                    ->label('Validade')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn (CooperationAgreement $record) => $record->is_expired ? 'danger' : 'gray'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Vigente',
                        'negotiation' => 'Em Negociação',
                        'renewing' => 'Em Renovação',
                        'expired' => 'Expirado',
                        'terminated' => 'Rescindido',
                        default => $state,
                    })
                    ->colors([
                        'success' => 'active',
                        'warning' => ['negotiation', 'renewing'],
                        'danger' => ['expired', 'terminated'],
                    ]),

                Tables\Columns\IconColumn::make('is_public')
                    ->label('Público')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'active' => 'Vigente',
                        'expired' => 'Expirado',
                        'renewing' => 'Em Renovação',
                        'negotiation' => 'Em Negociação',
                    ]),

                Tables\Filters\SelectFilter::make('scope')
                    ->label('Âmbito')
                    ->options([
                        'Nacional' => 'Nacional',
                        'Regional (SADC)' => 'Regional (SADC)',
                        'CPLP' => 'CPLP',
                        'Internacional Geral' => 'Internacional Geral',
                    ]),

                Tables\Filters\SelectFilter::make('organic_unit_id')
                    ->relationship('organicUnit', 'sigla')
                    ->label('Unidade Orgânica'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('download_pdf')
                    ->label('PDF Assinado')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (CooperationAgreement $record) => asset($record->document_file_path))
                    ->openUrlInNewTab()
                    ->visible(fn (CooperationAgreement $record) => filled($record->document_file_path)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCooperationAgreements::route('/'),
            'create' => Pages\CreateCooperationAgreement::route('/create'),
            'edit' => Pages\EditCooperationAgreement::route('/{record}/edit'),
        ];
    }
}