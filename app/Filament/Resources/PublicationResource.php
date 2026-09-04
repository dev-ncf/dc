<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicationResource\Pages;
use App\Filament\Resources\PublicationResource\RelationManagers;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Produção Científica';

    public static function form(Form $form): Form
    {
    return $form->schema([
        Forms\Components\Tabs::make('Metadados do Trabalho')
            ->tabs([
                // ABA 1: INFORMAÇÃO BÁSICA
                Forms\Components\Tabs\Tab::make('Identificação')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->columnSpanFull()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')->disabled()->dehydrated(),
                        Forms\Components\TextInput::make('author_name')->required()->label('Autor(es)'),
                        Forms\Components\TextInput::make('advisor_name')->label('Orientador (se aplicável)'),
                    ])->columns(2),

                // ABA 2: CLASSIFICAÇÃO ACADÉMICA
                Forms\Components\Tabs\Tab::make('Origem Académica')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        // Primeiro seleciona o Tipo
                        Forms\Components\Select::make('document_type_id')
                            ->label('Tipo de Documento')
                            ->relationship('documentType', 'name')
                            ->live() // Recarrega o form quando muda
                            ->required(),

                        // Instituição: Sempre visível, mas padrão UniRovuma
                        Forms\Components\TextInput::make('issuing_institution')
                            ->label('Instituição de Origem')
                            ->default('Universidade Rovuma')
                            ->helperText('Mude caso o trabalho tenha sido defendido noutra universidade.'),

                        // Faculdade: Só obrigatória para trabalhos de fim de curso internos
                        Forms\Components\Select::make('organic_unit_id')
                            ->label('Faculdade (UniRovuma)')
                            ->relationship('organicUnit', 'name')
                            ->live()
                            ->required(fn ($get) => in_array($get('document_type_id'), [1, 2, 3])) // Ex: IDs de Monografia/Tese
                            ->helperText('Selecione se for um trabalho interno da UniRovuma'),

                        // Curso: Só aparece se a faculdade for selecionada
                        Forms\Components\Select::make('course_id')
                            ->label('Curso / Programa')
                            ->options(fn($get) => \App\Models\Course::where('organic_unit_id', $get('organic_unit_id'))->pluck('name', 'id'))
                            ->hidden(fn ($get) => !$get('organic_unit_id')) // Esconde se não houver faculdade
                            ->required(fn ($get) => $get('organic_unit_id') !== null),

                        Forms\Components\Select::make('knowledge_area_id')
                            ->label('Área Científica Geral')
                            ->relationship('knowledgeArea', 'name')
                            ->required(),
                            
                        Forms\Components\TextInput::make('publication_year')
                            ->label('Ano de Publicação/Defesa')
                            ->numeric()
                            ->required(),
                    ])->columns(2),

                // ABA 3: RESUMO E FICHEIRO
                Forms\Components\Tabs\Tab::make('Conteúdo e Acesso')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Forms\Components\Textarea::make('abstract')->required()->rows(5)->columnSpanFull(),
                        Forms\Components\TagsInput::make('keywords')->required(),
                        Forms\Components\FileUpload::make('file_path')
                            ->label('Documento PDF')
                            ->directory('repository')
                            ->acceptedFileTypes(['application/pdf'])
                            ->required(),
                        Forms\Components\Select::make('visibility')
                            ->options([
                                'public' => 'Público Total',
                                'metadata_only' => 'Apenas Metadados',
                                'restricted' => 'Acesso Restrito',
                            ])->default('public'),
                    ])->columns(2),
            ])->columnSpanFull()
    ]);

    }

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('title')->searchable()->limit(40),
            Tables\Columns\TextColumn::make('author_name')->label('Autor'),
            Tables\Columns\TextColumn::make('documentType.name')->badge(),
            Tables\Columns\SelectColumn::make('status')
                ->options([
                    'pending' => 'Pendente',
                    'approved' => 'Aprovado',
                    'rejected' => 'Rejeitado',
                ]),
        ])
        ->actions([
            Tables\Actions\Action::make('Aprovar')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action(fn (Publication $record) => $record->update(['status' => 'approved']))
                ->requiresConfirmation()
                ->visible(fn($record) => $record->status !== 'approved'),
            
            Tables\Actions\EditAction::make(),
        ]);
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'edit' => Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}