@props(['search'=>null,'toolbar'=>null,'lable'=>null,'bulkactions'=>null])
<div class="card">
    <!--begin::Card header-->
    <div class="card-header border-0 pt-6">
        <!--begin::Card title-->
        <div class="card-title">

            <!--begin::Search-->
            <form>
                {{$search}}
            </form>


            @if(isset($lable))
                    <span class="card-label fw-bolder fs-3 mb-1">{{$lable}}</span>
            @endif

            @if(isset($title))
                    {{$title}}
            @endif



            <!--end::Search-->
        </div>
        <!--begin::Card title-->

        <!--begin::Card toolbar-->
        <div class="card-toolbar">

            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-table-toolbar="base">
                {{$toolbar}}


            </div>

            <!--end::Toolbar-->
            <!--begin::Group actions-->
            <div class="d-flex justify-content-end align-items-center d-none" data-table-toolbar="selected">

                <div class="fw-bolder me-5">
                    <span class="me-2" data-table-select="selected_count"></span>المحدد</div>
                {{isset($bulkactions)?$bulkactions:''}}

            </div>
            <!--end::Group actions-->


        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Table-->
        {{$slot}}
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->
