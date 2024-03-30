<?php

namespace App\Filament\Resources;

use Ariaieboy\FilamentJalaliDatetimepicker\Forms\Components\JalaliDateTimePicker;
use App\Filament\Resources\UserScheduleResource\Pages;
use App\Models\CompanyJob;
use App\Models\Schedule;
use App\Models\User;
use App\Utils\Roles;
use DateTimeZone;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables;

class UserScheduleResource extends Resource
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
                Select::make('company_job_id')
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
                            ->timezone('UTC')
                            ->jalali()
                            ->required(),
                        DateTimePicker::make('end_date')
                            ->native(false)
                            ->minDate(now())
                            ->timezone('UTC')
                            ->required()
                            ->jalali()
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                fn() => Schedule::query()
                    ->where('user_id', auth()->user()->id)
                    ->whereNotNull('schedule_date')
                    ->where('schedule_date', '>=', now())
            )
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('companyJob.name')
                    ->label('Job')
                    ->sortable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListUserSchedule::route('/'),
            'create' => Pages\CreateUserSchedule::route('/create'),
        ];
    }
}
