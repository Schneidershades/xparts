@component('mail::message')
# Hello {{ $user['name'] }}

Your xpart request **{{ $xp->id }}** has been **expired**. Please try again later

Thanks,<br>
{{ config('app.name') }}
@endcomponent
