@component('mail::message')
    # Hello {{$user->name}}

    You have changed your email, please confirm the new email by using the button below:

    @component('mail::button', ['url' => route('verify',$user->verification_token)])
        Verify Account
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
