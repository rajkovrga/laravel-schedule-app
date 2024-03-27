<?php

namespace App\Filament\Resources\UserScheduleResource\Pages;

use App\Filament\Resources\UserScheduleResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
class ListUserSchedule extends ListRecords
{
    protected static string $resource = UserScheduleResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
