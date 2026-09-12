@extends('layouts.admin')
@section('title',"الدعم الفني")
@section('page_title')
    <x-header.title name="لوحة التحكم">
        <x-header.breadcrumb-item name="الدعم الفني" href="{{route('system.contacts.index')}}"/>
        <x-header.breadcrumb-item name="الردود"/>
    </x-header.title>
@endsection
@section('content')
    <div class="flex-lg-row-fluid ms-lg-15">

        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
            <li class="nav-item ms-auto">
            </li>
        </ul>
    </div>



    <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
        <!--begin::Card-->
        <div class="card">
            <div class="card-header align-items-center py-5 gap-5">
                <div class="card-title">
                    <h4>
                        تفاصيل الرسالة

                    </h4>

                </div>
            </div>
            <div class="card-body">
                <!--begin::Title-->
                <!--end::Title-->
                <!--begin::Message accordion-->
                <div data-kt-inbox-message="message_wrapper">
                    <!--begin::Message header-->
                    <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                        <!--begin::Author-->
                        <div class="d-flex align-items-center">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50 me-4">
                                <span class="symbol-label" style="background-image:url({{asset('uploads/blank.png')}});"></span>
                            </div>
                            <!--end::Avatar-->
                            <div class="pe-5">
                                <!--begin::Author details-->
                                <div class="d-flex align-items-center flex-wrap gap-1">
                                    <a href="javascript:void(0)" class="fw-bolder text-dark text-hover-primary">{{$contact->name}}</a>
                                    <!--begin::Svg Icon | path: icons/duotune/abstract/abs050.svg-->
                                    <span class="svg-icon svg-icon-7 svg-icon-success mx-3">
																			<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																				<circle fill="currentColor" cx="12" cy="12" r="8"></circle>
																			</svg>
																		</span>
                                    <!--end::Svg Icon-->
                                    <span class="text-muted fw-bold">{{$contact->created_at ? $contact->created_at->diffForHumans() : ''}}</span>
                                </div>
                                <!--end::Author details-->
                                <!--begin::Message details-->
                                <!--end::Message details-->
                                <!--begin::Preview message-->
                                <div class="text-muted fw-semibold mw-450px d-none" data-kt-inbox-message="preview">With resrpect, i must disagree with Mr.Zinsser. We all know the most part of important part....</div>
                                <!--end::Preview message-->
                            </div>
                        </div>
                        <!--end::Author-->
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <!--begin::Date-->
                            <span class="fw-semibold text-muted text-end me-3">{{$contact->created_at? $contact->created_at->format('Y-m-d h:i:s') : ''}}</span>
                            <!--end::Date-->
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Message header-->
                    <!--begin::Message content-->
                    <div class="collapse fade show" data-kt-inbox-message="message">

                        <div class="pe-10 mx-5 py-5">
                            <div class="d-flex align-items-center flex-wrap gap-1">
                                <a href="javascript:void(0)"
                                   class="fw-bolder text-dark text-hover-primary">{{$contact->title}}</a>

                            </div>
                            <div class="text-muted fw-bold "
                                 data-kt-inbox-message="preview">{{$contact->message}}</div>
                        </div>

                    </div>
                    <!--end::Message content-->
                </div>
                <!--end::Message accordion-->
                <div class="separator my-6"></div>
                <!--begin::Message accordion-->
                @if($contact->replies->count()>0)
                    @foreach($contact->replies as $replay)
                        <div data-kt-inbox-message="message_wrapper">
                            <div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-50 me-4">
                                    <span class="symbol-label"
                                          style="background-image:url({{$replay->admin->image_url}});"></span>
                                    </div>
                                    <div class="pe-5 mx-5">
                                        <div class="d-flex align-items-center flex-wrap gap-1">
                                            <a href="javascript:void(0)"
                                               class="fw-bolder text-dark text-hover-primary">{{$replay->admin->name}}</a>

                                            <span class="badge badge-light-success fw-bolder mx-5">{{$replay->created_at->diffForHumans()}}</span>
                                        </div>
                                        <div class="text-muted fw-bold "
                                             data-kt-inbox-message="preview">{{$replay->replay_msg}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <div class="separator my-6"></div>
                        @endif
                    @endforeach
                @endif
                <form id="kt_inbox_reply_form" class="rounded border mt-10" method="POST"
                      action="{{route('system.contacts.replay.send')}}">
                    @csrf
                    <input type="hidden" value="{{$contact->id}}" name="contact_id">
                    <div class="d-block">
                        <div class="ql-toolbar ql-snow px-5 border-top-0 border-start-0 border-end-0">
                        <textarea name="message" id="" cols="30" rows="10"
                                  class="border-0  h-250px px-3 ql-container ql-snow w-100">{{old('message')}}</textarea>
                        </div>
                        <div class="d-flex justify-content-center gap-2 py-5 ps-8 pe-5 border-top">
                            <div class="d-flex align-items-center me-3">
                                <div class="btn-group me-4">
                                    <button type="submit" class="btn btn-primary fs-bold fs-4 px-10"
                                            data-kt-inbox-form="send">
                                        <span class="indicator-label">ارسال</span>
                                        <i class="fa fa-share"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <!--end::Card-->
    </div>

@endsection
