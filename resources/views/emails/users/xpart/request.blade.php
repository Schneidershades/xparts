@component('mail::message')
# Hello {{ $user['name'] }}


@if($xp->status == 'active')
A new xpart request for part vehicle part **{{ $xp->part->name }}** - **{{ $xp->vin->vehicle_name }}** has been created.
@endif

@if($xp->status == 'awaiting')
A new xpart request for part vehicle part **{{ $xp->part->name }}** - **{{ $xp->vin->vehicle_name }}** has been created and is awaiting approval.
@endif

@component('mail::button', ['url' => $link])
View xpart request
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
