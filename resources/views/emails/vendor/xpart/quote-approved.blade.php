@component('mail::message')
# Hello {{ $user['name'] }}

Your quote for xpart request **{{ $xp->id }}** has been **accepted**.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
