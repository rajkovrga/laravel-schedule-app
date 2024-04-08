<?php

namespace App\Filament\Widgets;

use App\Models\Schedule;
use Carbon\Carbon;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    /**
     * FullCalendar will call this function whenever it needs new event data.
     * This is triggered when the user clicks prev/next or switches views on the calendar.
     */
    public function fetchEvents(array $fetchInfo): array
    {
        return Schedule::query()
            ->whereNotNull('schedule_date')
            ->where('schedule_date', '>=' , $fetchInfo['start'])
            ->get()
            ->map(
                fn (Schedule $schedule) => EventData::make()
                    ->id($schedule->id)
                    ->title($schedule->companyJob->name)
                    ->start($schedule->schedule_date->toDateString())
                    ->end($schedule->schedule_date->addMinutes($schedule->companyJob->duration)->toDateString())
            )
            ->all();
    }
}
