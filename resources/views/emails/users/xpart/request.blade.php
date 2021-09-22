@component('mail::message')
# Hello {{ $user['name'] }}

A new xpart request for part vehicle part {{ $xp->part->name }} for {{ $xp->vin->vehicle_name }}.

@component('mail::button', ['url' => ''])
View xpart request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
