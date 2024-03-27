<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManagerScheduleResource\Pages;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ManagerScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('members')
                    ->label('Potential schedules')
                    ->default(Schedule::all(['dates'])->toArray())
                    ->schema([
                        DateTimePicker::make('start_date')
                            ->disabled(),
                        DateTimePicker::make('end_date')
                            ->disabled()
                    ])
                    ->grid(1)
                    ->reorderable(false)
                    ->addable(false)
                    ->deletable(false),
                DateTimePicker::make('schedule_date')
                    ->native(false)
                    ->minDate(now())
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('companyJob.name')
                    ->label('Job')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('schedule_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->query(
                fn() => Schedule::query()
                    ->where('company_id', auth()->user()->company_id)
                    ->orderByDesc('schedule_date')
            )
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
            'index' => Pages\ListSchedules::route('/'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
