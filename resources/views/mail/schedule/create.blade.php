@php use App\Models\Schedule; @endphp
@php
    /* @var Schedule $schedule**/
@endphp

<div>
    <p>Dear {{$schedule->user->email}},</p>

    <p>This email is to inform you that an appointment has been scheduled for you with the following details:</p>

    <p><b>Appointment ID:</b> {{$schedule->id}}</p>
    <p><b>Date and Time:</b> {{$schedule->scheduled_date}}</p>
    <p><b>Job Title:</b> {{$schedule->companyJob->name}}</p>
    <p><b>Company:</b> {{$schedule->company->name}}</p>
    <p>Please make a note of this appointment. If you have any questions or need to reschedule, feel free to contact
        us.</p>

    <p>Best regards,</p>
    <p>{{$schedule->company->name}}</p>
</div>

Thanks,<br>
{{ setting('general.app_name', 'App') }}
