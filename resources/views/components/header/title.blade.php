<!--begin::Page title-->
<div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
    <!--begin::Title-->
    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">{{$name}}</h1>
    <!--end::Title-->
    <!--begin::Separator-->
    <span class="h-20px border-gray-200 border-start mx-4"></span>
    <!--end::Separator-->
    <!--begin::Breadcrumb-->
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <x-header.breadcrumb-item :href="route('admin.dashboard')">
            <x-slot name="name">
                <x-lineawesome-home-solid/>


                {{--                <x-custom-Home class="w-25px svg-fill-muted"/>--}}
            </x-slot>
            <x-header.breadcrumb-item name="لوحة التحكم" :href="route('admin.dashboard')"/>

        </x-header.breadcrumb-item>
        {{$slot}}
    </ul>
    <!--end::Breadcrumb-->
</div>
<!--end::Page title-->
