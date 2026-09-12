@props(['title'=>''])
<a href="javascript:void(0);" class="btn btn-light btn-active-light-primary btn-sm btn-menu"
   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-indicator="off"
   data-kt-menu-flip="top-end">
    <span class="indicator-label">{{$title}}</span>
    <span class="indicator-progress">الرجاء الانتظار
        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
    <span class="svg-icon svg-icon-5 m-0"><x-lineawesome-angle-down-solid/></span></a>
<!--begin::Menu-->
<div
    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
    data-kt-menu="true">

    {{$slot}}
</div>
