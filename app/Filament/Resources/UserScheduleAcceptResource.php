<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManagerScheduleAcceptResource\Pages;
use App\Models\CompanyJob;
use App\Models\Schedule;
use App\Utils\Roles;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;

class UserScheduleAcceptResource extends Resource
{
    protected static ?string $model = Schedule::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Schedules';

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole([Roles::User]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Select::make('company_id')
                    ->relationship('company', 'name')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('job_id')
                    ->relationship('companyJob', 'name')
                    ->native(false)
                    ->reactive()
                    ->options(fn(Get $get) => CompanyJob::query()
                        ->select(['id', 'name'])
                        ->where('company_id', '=', (int)$get('company_id'))
                        ->get()
                        ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Repeater::make('members')
                    ->schema([
                        DateTimePicker::make('start_date')
                            ->native(false)
                            ->minDate(now())
                            ->required(),
                        DateTimePicker::make('end_date')
                            ->native(false)
                            ->required()
                    ])
                    ->columns(2)
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\CreateUserSchedule::route('/create'),
        ];
    }
}
