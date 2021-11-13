@component('mail::message')
# Hello {{ $user['name'] }}

Your quote for xpart request **{{ $xp->part->name }}** is **{{ $xp->status }}**.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
