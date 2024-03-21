<?php

namespace App\Filament\Pages;

use App\Utils\Roles;
use Closure;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;

class Settings extends BaseSettings
{
    protected static ?int $navigationSort = 30;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole(Roles::Admin);
    }

    public function schema(): array|Closure
    {
        return [
            Tabs::make('Settings')
                ->schema([
                    Tabs\Tab::make('General')
                        ->schema([
                            TextInput::make('general.app_name')
                                ->required(),
                        ]),
                    Tabs\Tab::make('Author')
                        ->schema([
                            TextInput::make('author.first_and_last_name'),
                        ]),
                    Tabs\Tab::make('Author Company')
                        ->schema([
                            TextInput::make('company.company_name'),
                            TextInput::make('company.address'),
                            TextInput::make('company.description'),
                        ]),

                ]),
        ];
    }
}
