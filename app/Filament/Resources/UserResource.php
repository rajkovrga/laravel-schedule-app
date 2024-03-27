<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Utils\Permissions;
use App\Utils\Roles;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?int $navigationSort = 0;
    protected static bool $shouldSkipAuthorization = true;
    protected static bool $isScopedToTenant = true;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function canAccess(): bool
    {
        return auth()->user()->hasAnyPermission([Permissions::ViewAllUsers, Permissions::ViewUsers]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->visible(fn() => auth()->user()->roles()->first()->name === Roles::Admin),
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'name')
                    ->visible(fn() => auth()->user()->roles()->first()->name === Roles::Admin),
                Select::make('roles')->relationship('roles', 'name')
                    ->default(Roles::CompanyUser)
                    ->visible(fn() => auth()->user()->roles()->first()->name === Roles::Admin),
                Select::make('roles')->relationship('roles', 'name')
                    ->options(Role::query()->where('name', '!=', Roles::Admin)->get()->pluck('name', 'id'))
                    ->visible(fn() => auth()->user()->roles()->first()->name === Roles::CompanyManager)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                fn() => auth()->user()->hasRole([Roles::Admin, Roles::User]
                ) ? User::query() : User::query()->where('company_id', auth()->user()->company_id)
            )
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->columns(static::getListTableColumns());
    }

    public static function getListTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->searchable(),
            Tables\Columns\TextColumn::make('email')
                ->searchable(),
            Tables\Columns\TextColumn::make('email_verified_at')
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('company.name')
                ->numeric()
                ->sortable()
                ->visible(fn() => auth()->user()->roles()->first()->name === Roles::Admin),
        ];
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
