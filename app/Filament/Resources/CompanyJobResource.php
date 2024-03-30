<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyJobResource\Pages;
use Filament\Forms\Components\TextInput;
use App\Models\CompanyJob;
use App\Utils\Permissions;
use App\Utils\Roles;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyJobResource extends Resource
{
    protected static ?string $model = CompanyJob::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?int $navigationSort = 20;

    public static function canAccess(): bool
    {
        return auth()->user()->hasAnyPermission([Permissions::ViewJobs, Permissions::ViewAllJobs]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('duration')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'name')
                    ->visible(fn() => auth()->user()->roles()->first()->name === Roles::Admin)
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->visible(fn() => auth()->user()->roles()->first()->name === Roles::Admin)
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanyJobs::route('/'),
            'create' => Pages\CreateCompanyJob::route('/create'),
            'edit' => Pages\EditCompanyJob::route('/{record}/edit'),
        ];
    }
}
