<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicationResource\Pages;
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
    protected static ?string $navigationLabel = 'Repositório de Publicações';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Metadados do Trabalho')
                ->tabs([
                    // ABOLA 1: IDENTIFICAÇÃO
                    Forms\Components\Tabs\Tab::make('Identificação')
                        ->icon('heroicon-o-identification')
                        ->schema([
                            Forms\Components\Select::make('document_type_id')
                                ->label('Tipo de Documento')
                                ->relationship('documentType', 'name')
                                ->live()
                                ->required()
                                ->columnSpanFull(),

                            Forms\Components\TextInput::make('title')
                                ->label('Título do Trabalho / Livro / Artigo')
                                ->required()
                                ->columnSpanFull()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),

                            Forms\Components\TextInput::make('slug')
                                ->disabled()
                                ->dehydrated(),

                            Forms\Components\TextInput::make('author_name')
                                ->required()
                                ->label('Nome do Autor'),

                            Forms\Components\Select::make('author_qualification')
                                ->label('Habilitações Literárias do Autor')
                                ->options([
                                    'Licenciatura' => 'Licenciatura',
                                    'Mestrado' => 'Mestrado',
                                    'Doutoramento' => 'Doutoramento',
                                    'PhD' => 'PhD',
                                    'Outras' => 'Outras',
                                ])
                                ->required(),

                            Forms\Components\TextInput::make('advisor_name')
                                ->label('Orientador (se aplicável)')
                                ->hidden(fn ($get) => self::isArticleOrBook($get)), // Opcional ocultar se for livro/artigo
                        ])->columns(2),

                    // ABOLA 2: ORIGEM ACADÉMICA / PUBLICAÇÃO
                    Forms\Components\Tabs\Tab::make('Detalhes da Publicação')
                        ->icon('heroicon-o-academic-cap')
                        ->schema([
                            Forms\Components\TextInput::make('issuing_institution')
                                ->label('Instituição de Origem / Editora')
                                ->default('Universidade Rovuma'),

                            Forms\Components\TextInput::make('publication_year')
                                ->label('Ano de Publicação / Defesa')
                                ->numeric()
                                ->required(),

                            Forms\Components\TextInput::make('publication_country')
                                ->label('País de Publicação')
                                ->default('Moçambique')
                                ->required(),

                            // Campos específicos para Capítulos de Livros
                            Forms\Components\TextInput::make('book_title')
                                ->label('Título do Livro (Onde o capítulo está inserido)')
                                ->required(fn ($get) => self::isBookChapter($get))
                                ->hidden(fn ($get) => !self::isBookChapter($get))
                                ->columnSpanFull(),

                            // Campos específicos para Artigos Científicos
                            Forms\Components\TextInput::make('journal_name')
                                ->label('Nome da Revista Científica')
                                ->required(fn ($get) => self::isScientificArticle($get))
                                ->hidden(fn ($get) => !self::isScientificArticle($get)),

                            Forms\Components\TextInput::make('journal_edition')
                                ->label('Edição / Volume / Número da Revista')
                                ->hidden(fn ($get) => !self::isScientificArticle($get)),

                            // Identificadores (ISBN / ISSN / DOI)
                            Forms\Components\TextInput::make('isbn_issn')
                                ->label('Número de ISBN ou ISSN')
                                ->dehydrateStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),

                            Forms\Components\TextInput::make('doi')
                                ->label('DOI (Digital Object Identifier)')
                                ->dehydrateStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),
                            // Faculdades e Cursos (Para Teses/Monografias)
                            Forms\Components\Select::make('organic_unit_id')
                                ->label('Faculdade (UniRovuma)')
                                ->relationship('organicUnit', 'name')
                                ->live()
                                ->nullable(),

                            Forms\Components\Select::make('course_id')
                                ->label('Curso / Programa')
                                ->options(fn($get) => \App\Models\Course::where('organic_unit_id', $get('organic_unit_id'))->pluck('name', 'id'))
                                ->hidden(fn ($get) => !$get('organic_unit_id')),

                            Forms\Components\Select::make('knowledge_area_id')
                                ->label('Área Científica Geral')
                                ->relationship('knowledgeArea', 'name'),
                        ])->columns(2),

                    // ABOLA 3: CONTEÚDO E ACESSO
                    Forms\Components\Tabs\Tab::make('Conteúdo e Acesso')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            Forms\Components\Textarea::make('abstract')
                                ->label('Resumo')
                                ->required()
                                ->rows(5)
                                ->columnSpanFull(),

                            Forms\Components\TagsInput::make('keywords')
                                ->label('Palavras-chave'),

                            Forms\Components\TextInput::make('external_link')
                                ->label('Link Externo')
                                ->url()
                                ->dehydrateStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),

                            Forms\Components\FileUpload::make('file_path')
                                ->label('Documento PDF (Ficheiro)')
                                ->directory('repository')
                                ->acceptedFileTypes(['application/pdf'])
                                ->required(fn (string $operation): bool => $operation === 'create')
                                ->dehydrateStateUsing(fn ($state, ?Publication $record) => $state ?? $record?->file_path),

                            Forms\Components\Select::make('visibility')
                                ->label('Visibilidade')
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
                Tables\Columns\TextColumn::make('title')->searchable()->limit(40)->label('Título'),
                Tables\Columns\TextColumn::make('author_name')->searchable()->label('Autor'),
                Tables\Columns\TextColumn::make('author_qualification')->label('Habilitações'),
                Tables\Columns\TextColumn::make('documentType.name')->badge()->label('Tipo'),
                Tables\Columns\TextColumn::make('publication_country')->label('País'),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pendente',
                        'approved' => 'Aprovado',
                        'rejected' => 'Rejeitado',
                    ]),
            ])
            ->filters([
                // Pode adicionar filtros por tipo de documento ou ano aqui
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

    // Funções auxiliares para verificar o tipo de documento selecionado
    // (Certifique-se de ajustar os IDs ou os nomes correspondentes na sua base de dados)
    protected static function isBookChapter($get): bool
    {
        $typeId = $get('document_type_id');
        // Exemplo: procure pelo nome ou ID correspondente a "Capítulo de Livro"
        $type = \App\Models\DocumentType::find($typeId);
        return $type && Str::contains(strtolower($type->name), 'capítulo');
    }

    protected static function isScientificArticle($get): bool
    {
        $typeId = $get('document_type_id');
        $type = \App\Models\DocumentType::find($typeId);
        return $type && Str::contains(strtolower($type->name), 'artigo');
    }

    protected static function isArticleOrBook($get): bool
    {
        $typeId = $get('document_type_id');
        $type = \App\Models\DocumentType::find($typeId);
        if (!$type) return false;
        
        $name = strtolower($type->name);
        return Str::contains($name, 'livro') || Str::contains($name, 'artigo') || Str::contains($name, 'capítulo');
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