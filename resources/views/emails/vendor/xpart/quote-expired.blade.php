@component('mail::message')
# Hello {{ $user['name'] }}

Your quote for xpart request **{{ $xp->part->name }}** is **expired**.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
