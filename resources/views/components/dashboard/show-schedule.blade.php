@php use App\Models\Schedule; @endphp
@php /* @var Schedule $record */ @endphp

<div>
    <b>Schedule ID</b>
    <p>{{$record->id}}</p>
    <b>Job Name</b>
    <p>{{$record->companyJob->name}}</p>
    <b>Company</b>
    <p>{{$record->company->name}}</p>
    <b>Company Manager</b>
    <p>{{$record->manager->email}}</p>
    <b>Schedule Date Start</b>
    <p>{{$record->schedule_date}}</p>
    <b>Schedule Date End</b>
    <p>{{$record->schedule_date->addMinutes($record->companyJob->duration)}}</p>
    <b>User Email</b>
    <p>{{$record->user->email}}</p>
</div>
