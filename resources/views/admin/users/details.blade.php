@extends('layouts.admin')
@section('title',lng('dashboard.users.users'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')">
        <x-header.breadcrumb-item :name="lng('dashboard.users.users','العملاء')" href="{{route('system.users.index')}}"/>
        <x-header.breadcrumb-item name="{{lng('dashboard.users.show_details','عرض تفاصيل'). $user->name}}"/>
    </x-header.title>
@endsection
@push('css')

    @endpush
@section('content')
    <!--begin::Navbar-->
    <div class="card mb-2">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                <!--begin: Pic-->

                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex justify-content-start align-items-start flex-wrap mb-2">
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-80px symbol-lg-120px symbol-fixed position-relative">
                                <img src="{{$user->image_url}}" alt="image">
                                {{--                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>--}}
                            </div>
                        </div>
                        <!--begin::User-->
                        <div class="d-flex flex-column">
                            <!--begin::Name-->
                            <div class="d-flex align-items-center mb-2">
                                <a href="javascript:void(0);" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1">
                                    {{$user->name}}
                                </a>
                            </div>
                            <!--end::Name-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                                <a href="javascript:void(0);"
                                   class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                    <span class="svg-icon svg-icon-4 me-1"><x-metronic-Phone/></span>
                                    <!--end::Svg Icon-->{{$user->mobile_prefix}}</a>
                                @if( $user->email)
                                <a href="javascript:void(0);" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                    <!--begin::Svg Icon | path: icons/duotune/communication/com011.svg-->
                                    <span class="svg-icon svg-icon-4 me-1">
																	<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																		<path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor"></path>
																		<path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor"></path>
																	</svg>
																</span>
                                    <!--end::Svg Icon-->{{$user->email ?? '-'}}</a>
                                 @endif
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->

                    </div>
                </div>
                <!--end::Info-->
            </div>
            <!--end::Details-->
            <!--begin::Navs-->
            <ul class="nav  nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
                <!--begin::Nav item-->
                <li class="nav-item mt-2">
                    <a class="nav-link text-active-primary ms-0 me-10 py-5  active" data-bs-toggle="tab"
                       href="#t1">@lng('dashboard.general.details','تفاصيل')</a>
                </li>


                <!--end::Nav item-->

            </ul>
            <!--begin::Navs-->
        </div>
    </div>
    <!--end::Navbar-->
    <!--begin::Row-->
    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade active show" id="t1" role="tabpanel">

            <div class="card card-xxl-stretch mb-5 mb-xxl-10">
                <!--begin::Body-->
                <div class="card-body pb-0">

                    <div class="row g-5 mb-5">

                        <div class="col-sm-3">

                            <div class="fw-bold fs-7 text-gray-600 mb-1">@lng('dashboard.general.created_at','تاريخ الاضافة') :</div>

                            <div
                                class="fw-bolder fs-6 text-gray-800">{{$user->created_at->toDateString()}}</div>

                        </div>


                        <div class="col-sm-3">

                            <div class="fw-bold fs-7 text-gray-600 mb-1">@lng('dashboard.general.Name') :</div>
                            <div class="fw-bolder fs-6 text-gray-800">{{$user->name}}</div>


                        </div>
                        <div class="col-sm-3">

                            <div class="fw-bold fs-7 text-gray-600 mb-1">@lng('dashboard.general.mobile') :</div>
                            <div class="fw-bolder fs-6 text-gray-800">{{$user->mobile_prefix}}</div>


                        </div>
                        @if($user->email)
                        <div class="col-sm-3">

                            <div class="fw-bold fs-7 text-gray-600 mb-1">@lng('dashboard.general.email') :</div>
                            <div class="fw-bolder fs-6 text-gray-800">{{$user->email ?? '-'}}</div>


                        </div>
                        @endif



                            <div class="col-sm-3">
                                <div class="fw-bold fs-7 text-gray-600 mb-1">@lng('dashboard.general.device_type','نوع الجهاز') :</div>
                                <div class="fw-bolder fs-6 text-white badge badge-primary">{{@$user->device_type ?? '-'}}</div>
                            </div>

                    </div>


                </div>
                <!--end::Body-->

            </div>
        </div>



    </div>


@endsection

@push('js')


@endpush
