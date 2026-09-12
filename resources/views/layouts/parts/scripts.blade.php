<!--end::Demo Panel-->
<script>var HOST_URL = "{{url('/')}}";var UrlForAssets = "{{url('/')}}";var UrlForScripts = "{{url('/')}}";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Theme Bundle-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script>
    $('#flash-overlay-modal').modal();
</script>
<script src="{{asset('assets/custom/datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/custom/datepicker/locales/bootstrap-datepicker.ar.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/custom/ckeditor/translations/ar.js')}}"></script>
<script src="{{asset('assets/custom/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('assets/custom/ar_MA.js')}}"></script>
<script src="{{asset('assets/custom/ar_MA.js')}}"></script>
{{--<script src="{{asset('assets/js/fancybox.umd.js')}}"></script>--}}

<script src="{{asset('assets/custom/main.js')}}" type="text/javascript"></script>


<script>

    @if(count($errors->all()))
    @php
        $err='<ul class="text-right" style="padding:0 20px;">';
        foreach ($errors->all() as $e){
            $err.='<li>'.$e.'</li>';
        }
        $err.='</ul>'
    @endphp
    Swal.fire({
        toast:true,
        html: '{!! $err !!}',
        timer: 30000,
        position:'bottom-start',
        timerProgressBar: true,
        showConfirmButton: false,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        },
        customClass: {
            container: 'm-2 p-0',
            header: 'm-0 p-0',
            content: 'm-0 p-0',
            htmlContainer: 'm-0 p-0',
        }
    })
    @endif




</script>
