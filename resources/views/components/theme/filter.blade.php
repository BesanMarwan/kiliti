<!--begin::Filter-->
<button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">

    <span class="svg-icon svg-icon-2"><x-metronic-Filter/></span><span>فلترة</span></button>
<!--begin::Menu 1-->
<div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
    <!--begin::Header-->
    <div class="px-7 py-5">
        <div class="fs-5 text-dark fw-bolder">خيارات الفلترة</div>
    </div>
    <!--end::Header-->
    <!--begin::Separator-->
    <div class="separator border-gray-200"></div>
    <!--end::Separator-->
    <!--begin::Content-->
    <div class="px-7 py-5">
        <form>
            {{$slot}}
            <!--begin::Actions-->
            <div class="d-flex justify-content-end">
                <button type="reset" class="btn btn-white btn-active-light-primary fw-bold me-2 px-6">الغاء</button>
                <button type="submit" class="btn btn-primary fw-bold px-6">تطبيق</button>
            </div>
            <!--end::Actions-->
        </form>

    </div>
    <!--end::Content-->
</div>
<!--end::Menu 1-->
<!--end::Filter-->
