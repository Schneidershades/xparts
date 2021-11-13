@component('mail::message')
# Hello {{ $user['name'] }}

A new xpart request for part vehicle part **{{ $xp->part->name }}** - **{{ $xp->vin->vehicle_name }}** has been created.

@component('mail::button', ['url' => $link])
View xpart request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
