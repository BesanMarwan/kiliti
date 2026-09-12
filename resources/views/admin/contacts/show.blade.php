@extends('layouts.admin')
@section('title',"الدعم الفني")
@section('page_title')
    <x-header.title name="لوحة التحكم">
        <x-header.breadcrumb-item name="الدعم الفني" href="{{route('system.contacts.index')}}"/>
        <x-header.breadcrumb-item name="عرض تفاصيل الرسالة"/>
    </x-header.title>
@endsection
@section('content')
    <div class="flex-lg-row-fluid ms-lg-15">

        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
            <li class="nav-item ms-auto">
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="flex-column  w-lg-450px w-xl-400px mb-10">
        <div class="card mb-5 mb-xl-8">
                <div class="card-body">
                    <div class="d-flex flex-center flex-column py-5">

                        <a  class="fs-3 text-gray-800 text-active-muted text-hover-primary fw-bolder mb-3 mt-3">{{$contact->name}} </a>


                    </div>
                    <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bolder rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">
                             التفاصيل
                            <span class="ms-2 rotate-180">
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black"></path>
                                        </svg>
                                    </span>
                                </span></div>

                    </div>
                    <div class="separator"></div>
                    <div id="kt_user_view_details" class="collapse show">
                        <div class="pb-5 fs-6">

                            <div class="d-flex align-items-center my-8">
                                <div class="flex-grow-1">
                                    <span class="text-gray-800 text-hover-primary fw-bolder fs-7">اسم المرسل</span>
                                </div>
                                <span class=" w-50  d-inline-block text-truncate badge badge-light-primary fs-8 fw-bolder">{{$contact->name??'-'}}</span>
                            </div>


                            <div class="d-flex align-items-center my-8">
                                <div class="flex-grow-1">
                                    <span class="text-gray-800 text-hover-primary fw-bolder fs-7">الهاتف</span>
                                </div>
                                <span class=" w-50  d-inline-block text-truncate badge badge-light-primary fs-8 fw-bolder">{{$contact->mobile_prefix??'-'}}</span>
                            </div>

                            <div class="d-flex align-items-center my-8">
                                <div class="flex-grow-1">
                                    <span class="text-gray-800 text-hover-primary fw-bolder fs-7">الايميل</span>
                                </div>
                                <span class=" d-inline-block text-truncate badge badge-light-primary fs-8 fw-bolder">{{@$contact->email??'-'}}</span>
                            </div>

                            <div class="d-flex  flex-column my-8">
                                    <span class="text-gray-800 text-hover-primary fw-bolder fs-7">نص الرسالة</span>
                                <div class="border-3 mt-3 box">
                                    <p style="line-height:16pt" class=" w-100 d-inline-block text-wrap text-truncate badge badge-light-primary fs-8 fw-bolder">{{@$contact->message??'-'}}</p>

                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-column  w-lg-600px w-xl-600px mb-10">
    <div class="card  m-auto">
        <div class="card-header card-header-stretch">
            @if($contact->reply =='' && $contact->reply == null)
            <h3 class="card-title">الدعم الفني -ارسال رد </h3>
            @else
                <h3 class="card-title">الدعم الفني -رد الادارة  </h3>
            @endif
        </div>

        <div class="card-body">

            <form id="kt_inbox_reply_form" class="rounded border mt-10" method="POST"
                  action="{{route('system.contacts.replay.send')}}">
                @csrf
                <input type="hidden" value="{{$contact->id}}" name="contact_id">
                <div class="d-block">
                    <div class="ql-toolbar ql-snow px-5 border-top-0 border-start-0 border-end-0">
                        <textarea name="message" id="" cols="30" rows="10" @if($contact->reply !='' && $contact->reply != null) readonly="readonly"  @endif
                                  class="border-0  h-250px px-3 ql-container ql-snow w-100 fa-2x">{{old('message',$contact->reply)}}</textarea>
                    </div>
                    @if($contact->reply =='' && $contact->reply == null)
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
                        @endif
                </div>
            </form>
        </div>

    </div>
    </div>
    </div>


    <div class="row">

    </div>

@endsection
