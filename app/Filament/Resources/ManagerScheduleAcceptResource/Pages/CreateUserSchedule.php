<?php

namespace App\Filament\Resources\ManagerScheduleAcceptResource\Pages;

use App\Filament\Resources\UserScheduleAcceptResource;
use Carbon\CarbonImmutable;
use Filament\Resources\Pages\CreateRecord;

class CreateUserSchedule extends CreateRecord
{
    protected static string $resource = UserScheduleAcceptResource::class;

    public const string DATE_FORMAT = 'Y-m-d H:i:s';

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $members = $data['members'] ?? [];
        unset($data['members']);

        return [
            ...$data,
            'dates' => collect($members)
                ->map(function ($el) {
                    ['start_date' => $start, 'end_date' => $end] = $el;

                    return [
                        CarbonImmutable::createFromFormat(self::DATE_FORMAT, $start),
                        CarbonImmutable::createFromFormat(self::DATE_FORMAT, $end)
                    ];
                })
                ->toArray(),
        ];
    }
}
