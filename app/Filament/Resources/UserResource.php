<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Controle de Acesso';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Dados Pessoais')
                ->schema([
                    Forms\Components\TextInput::make('name')->required(),
                    Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('phone'),
                    Forms\Components\TextInput::make('orcid')->label('Identificador ORCID'),
                ])->columns(2),

            Forms\Components\Section::make('Vínculo e Segurança')
                ->schema([
                    Forms\Components\Select::make('organic_unit_id')
                        ->relationship('organicUnit', 'sigla')
                        ->searchable()->preload()->required(),
                    Forms\Components\Select::make('user_type')
                        ->options([
                            'admin' => 'Administrador',
                            'docente' => 'Docente',
                            'estudante' => 'Estudante',
                            'parecerista' => 'Parecerista',
                        ])->required(),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $context): bool => $context === 'create')
                        ->label(fn (string $context) => $context === 'edit' ? 'Nova Senha (deixe vazio para manter)' : 'Senha'),
                    Forms\Components\Toggle::make('is_active')->default(true)->label('Conta Ativa'),
                ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('organicUnit.sigla')->label('Unidade')->badge(),
                Tables\Columns\TextColumn::make('user_type')->label('Tipo')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_type')->options([
                    'admin' => 'Admin', 'docente' => 'Docente', 'estudante' => 'Estudante'
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}