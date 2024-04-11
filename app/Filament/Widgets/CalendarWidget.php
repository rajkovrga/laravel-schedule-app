<?php

namespace App\Filament\Widgets;

use App\Models\Schedule;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Data\EventData;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Schedule::class;


    protected function viewAction(): Action
    {
        return Actions\ViewAction::make()
            ;
    }

    /**
     * FullCalendar will call this function whenever it needs new event data.
     * This is triggered when the user clicks prev/next or switches views on the calendar.
     */
    public function fetchEvents(array $fetchInfo): array
    {
        $query = Schedule::query()
            ->whereNotNull('schedule_date')
            ->where('schedule_date', '>=', $fetchInfo['start'])
            ->where('schedule_date', '<', $fetchInfo['end']);
        if (auth()->user()->company_id !== null) {
            $query->where('company_id', auth()->user()->company_id);
        } else {
            $query->where('user_id', auth()->user()->id);
        }

        return $query->get()
            ->map(
                fn(Schedule $schedule) => EventData::make()
                    ->id($schedule->id)
                    ->title($schedule->companyJob->name)
                    ->start($schedule->schedule_date)
                    ->end($schedule->schedule_date->addMinutes($schedule->companyJob->duration))
            )
            ->toArray();
    }
}
