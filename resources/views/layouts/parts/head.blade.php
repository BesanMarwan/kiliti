<!DOCTYPE html>

<head>
    <base href="{{url('/')}}">
    <meta charset="utf-8" />
    <title>@lng('dashboard.general.besan','بيسان') -  @yield('title','الادارة')</title>
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{csrf_token()}}" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800" rel="stylesheet">

    <!--end::Fonts-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ session('mode','light') == 'light'?asset('assets/plugins/global/plugins.bundle.rtl.css'):asset('assets/plugins/global/plugins.dark.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">--}}

@if(App::getLocale()=='ar')
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ session('mode','light') == 'light'?asset('assets/css/style.bundle.rtl.css'):asset('assets/css/style.dark.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ session('mode','light') == 'light'?asset('assets/css/style.bundle.css'):asset('assets/css/style.dark.bundle.css') }}" rel="stylesheet" type="text/css" />
        @endif
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
{{--    <link type="text/css" rel="stylesheettylesheet" href="{{asset('assets/css/fancybox.css')}}" />--}}

    <!--end::Global Theme Styles-->
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->

    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />

<style>
body.swal2-toast-shown .swal2-container.swal2-bottom-start, body.swal2-toast-shown .swal2-container.swal2-bottom-left{
     /*bottom :-20% !important;*/
    }

</style>
    @stack('css')
</head>
