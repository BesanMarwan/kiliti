
@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    New message from Contact Us - رسالة جديدة من اتصل بنا
    <br>
    Name:{{$name}}
    <br>
    Mobile:{{$mobile}}
    <br>
    Email:{{$email}}
    <br>
    Title:{{$title}}
    <br>
    Message:{{$mess}}
    <br>
    Thanks,
    {{ config('app.name') }}


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
