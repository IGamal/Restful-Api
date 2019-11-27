@component('mail::message')
    # Hello {{$user->name}}

    Thank you for create an account. To verify your email please use the button below:

    @component('mail::button', ['url' => route('verify',$user->verification_token)])
        Verify Account
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
