<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;

use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Portal Institucional';
    protected static ?string $label = 'Notícia/Edital';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Conteúdo Principal')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                    
                    Forms\Components\TextInput::make('slug')->disabled()->dehydrated()->required(),
                    
                    Forms\Components\RichEditor::make('content')
                        ->required()
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Configurações e Metadados')
                ->schema([
                    Forms\Components\Select::make('type')
                        ->options([
                            'news' => 'Notícia',
                            'event' => 'Evento/Agenda',
                            'announcement' => 'Edital',
                            'regulation' => 'Regulamento',
                        ])->required()->live(),
                    
                    Forms\Components\FileUpload::make('featured_image')
                        ->label('Imagem de Destaque')
                        ->image()->directory('blog'),

                    // Campos visíveis apenas se for EVENTO
                    Forms\Components\DateTimePicker::make('event_start_date')
                        ->label('Início do Evento')
                        ->visible(fn (Forms\Get $get) => $get('type') === 'event'),
                    
                    Forms\Components\TextInput::make('location')
                        ->label('Local do Evento')
                        ->visible(fn (Forms\Get $get) => $get('type') === 'event'),

                    Forms\Components\Toggle::make('is_published')
                        ->label('Publicar Imediatamente')
                        ->default(true),
                ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')->circular(),
                Tables\Columns\TextColumn::make('title')->searchable()->limit(30),
                Tables\Columns\TextColumn::make('type')->badge(),
                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Publicado'),
                Tables\Columns\TextColumn::make('created_at')->label('Data')->date(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')->options([
                    'news' => 'Notícias', 'event' => 'Eventos', 'announcement' => 'Editais'
                ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}