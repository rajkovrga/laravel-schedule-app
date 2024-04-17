<?php

namespace App\Filament\Resources\ManagerScheduleResource\Pages;

use App\Filament\Resources\ManagerScheduleResource;
use App\Models\Schedule;
use App\Models\User;
use App\Notifications\CreateSchedule;
use App\Utils\Roles;
use Filament\Resources\Pages\EditRecord;

class EditSchedule extends EditRecord
{
    protected static string $resource = ManagerScheduleResource::class;

    protected function afterSave(): void
    {
        /** @var Schedule $record */
        $record = $this->record;
        $record->user->notify(new CreateSchedule($record));
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['manager_id'] = auth()->user()->id;
        return $data;
    }
}
