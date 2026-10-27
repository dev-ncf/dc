<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
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
                    Forms\Components\TextInput::make('name')->required()->label('Nome Completo'),
                    Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('phone')->label('Telefone'),
                    Forms\Components\TextInput::make('orcid')->label('Identificador ORCID'),
                ])->columns(2),

            Forms\Components\Section::make('Vínculo e Segurança')
                ->schema([
                    Forms\Components\Select::make('organic_unit_id')
                        ->relationship('organicUnit', 'sigla')
                        ->searchable()->preload()->nullable()->label('Unidade Orgânica'),

                    // ========================================================
                    // APLICAÇÃO DE ROLES (PERFIS) VIA RELACIONAMENTO
                    // ========================================================
                    Forms\Components\Select::make('roles')
                        ->relationship('roles', 'name')
                        ->multiple() // Permite atribuir mais de um perfil se desejar
                        ->preload()
                        ->searchable()
                        ->label('Perfis de Acesso (Roles)')
                        ->required(),

                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->dehydrated(fn ($state) => filled($state))
                        ->required(fn (string $context): bool => $context === 'create')
                        ->label(fn (string $context) => $context === 'edit' ? 'Nova Senha (deixe vazio para manter)' : 'Senha'),

                    Forms\Components\Toggle::make('is_active')
                        ->default(true)
                        ->label('Conta Ativa'),
                ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->label('Nome'),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('organicUnit.sigla')->label('Unidade')->badge(),
                
                // Exibe as Roles como Badges coloridas
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Perfis (Roles)')
                    ->badge()
                    ->color('primary')
                    ->separator(','),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
            ])
            ->filters([
                // Filtro por Role
                Tables\Filters\SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->label('Filtrar por Perfil'),
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