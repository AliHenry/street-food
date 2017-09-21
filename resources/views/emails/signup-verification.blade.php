@component('mail::message')

# Welcome {{$user->name}},

#### <center>ACCOUNT REGISTRATION CONFIRMATION</center>
<center>Thank you for creating a new account. To use the full range of services you will need to verify the email address on your account.</center>


@component('mail::button', ['url' => $user->verification_token])
    VERIFY NOW
@endcomponent

<center>Or Enter the Verification Code</center>
<br>
##<center>{{$user->code}}</center>
<br>

<center>Verifying your email address will give you full access to the #Street Food “Cloud”</center>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
