@component('mail::message')
# Hello {{ $user['name'] }}

A new quote for part vehicle part **{{ $xp->part->name }}** - **{{ $xp->vin->vehicle_name }}** has been sent to you.

@component('mail::button', ['url' => $link])
View Bid
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
