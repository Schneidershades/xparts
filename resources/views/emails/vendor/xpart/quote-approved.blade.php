@component('mail::message')
# Hello {{ $user['name'] }}

Your quote for xpart request **{{ $xp->part->name }}** has been **accepted**.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
