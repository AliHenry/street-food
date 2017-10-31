@component('mail::message')

# Welcome {{$user->name}},

Thank you for creating a new account. To use the full range of our services please login and complete your profile information.


@component('mail::button', ['url' => $user->verification_token])
    Login
@endcomponent

<center>Completing your profile details will give you full access to #Street Food “Cloud”</center>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
