@component('mail::message')
# Hello {{ $user['name'] }}

Your quote for xpart request **{{ $xp->id }}** has been **expired**.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
