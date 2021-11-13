@component('mail::message')
# Hello {{ $user['name'] }}

Your xpart request **{{ $xp->id }}** is **expired**. Please try again later

Thanks,<br>
{{ config('app.name') }}
@endcomponent
