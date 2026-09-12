
@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img width="100" height="100" src="{{asset('admin/imgs/logo.png') }}" alt="{{ config('app.name') }} Logo">
            <h4>{{ config('app.name') }}</h4>
        @endcomponent
    @endslot

    Your have received this email upon your forget password request, if that request is from you,
    Please use the following link to reset your password.
        @component('mail::button', ['url' => route($url,['token'=>$code])])
          Change Password<br/>
        @endcomponent

    Or copy the link below:
         {{ route($url,['token'=>$code]) }}

    Please note that the link will expire in 12 hours from now.
    Thanks,
    {{ config('app.name') }}


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
