@component('mail::message')
# Hello {{ $user['name'] }}

Your password was changed successfully. You can now login with the following details:

<h3>{{$passwordDetails}}</h3>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
