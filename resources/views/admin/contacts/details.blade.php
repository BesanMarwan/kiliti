@extends('layouts.admin')
@section('title',"الدعم الفني")
@section('page_title')
    <x-header.title name="لوحة التحكم">
        <x-header.breadcrumb-item name="الدعم الفني" href="{{route('system.contacts.index')}}"/>
        <x-header.breadcrumb-item name="عرض تفاصيل الرسالة"/>
    </x-header.title>
@endsection
@section('content')

    <div class="row m-auto justify-content-center">
        <div class="col-md-8 ">
            <div class="card" id="kt_chat_messenger">
                <!--begin::Card header-->
                <div class="card-header" id="kt_chat_messenger_header">
                    <!--begin::Title-->
                    <div class="card-title">
                        <!--begin::User-->
                        <div class="d-flex justify-content-center flex-column me-3">
                            <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">{{$contact->name}}</a>

                            <!--begin::Info-->
                            <div class="mb-0 lh-1">
                                <span class="fs-7 fw-semibold text-muted">{{$contact->country->prefix.$contact->mobile}}</span>
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::User-->
                    </div>
                    <!--end::Title-->

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Menu-->
                        <!--end::Menu-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body" id="kt_chat_messenger_body">
                    <!--begin::Messages-->
                    <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px">



                        <!--begin::Message(in)-->
                        <div class="d-flex justify-content-start mb-10 ">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column align-items-start">
                                <!--begin::User-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Avatar--><div class="symbol  symbol-35px symbol-circle "><img alt="Pic" src="{{$contact->creator?->image_url}}"></div><!--end::Avatar-->
                                    <!--begin::Details-->
                                    <div class="ms-3">
                                        <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">{{$contact->name}}</a>
                                        <span class="text-muted fs-7 mb-1">{{$contact->created_at ? $contact->created_at->diffForHumans() : ''}}</span>
                                    </div>
                                    <!--end::Details-->

                                </div>
                                <!--end::User-->

                                <!--begin::Text-->
                                <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text">
                                    {{$contact->message}}           </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Message(in)-->

                        @foreach($contact->replies as $replay)

                            @if($replay->type == 'admin')
                        <!--begin::Message(out)-->
                        <div class="d-flex justify-content-end mb-10 ">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column align-items-end">
                                <!--begin::User-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Details-->
                                    <div class="me-3">
                                        <span class="text-muted fs-7 mb-1">{{$replay->created_at ? $replay->created_at->diffForHumans() : ' '}}</span>
                                        <a href="javascript:void(0);" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">{{$replay->owner->name}}</a>
                                    </div>
                                    <!--end::Details-->

                                    <!--begin::Avatar--><div class="symbol  symbol-35px symbol-circle "><img alt="Pic" src="{{$replay->owner->image_url}}"></div><!--end::Avatar-->
                                </div>
                                <!--end::User-->

                                <!--begin::Text-->
                                <div class="p-5 rounded bg-light-primary text-dark fw-semibold mw-lg-400px text-end" data-kt-element="message-text">
                                  {{$replay->message}}
                                </div>
                                 <!--end::Text-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Message(out)-->
                            @else

                        <!--begin::Message(in)-->
                        <div class="d-flex justify-content-start mb-10 ">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column align-items-start mb-10">
                                <!--begin::User-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Avatar--><div class="symbol  symbol-35px symbol-circle "><img alt="Pic" src="{{$replay->owner->image_url}}"></div><!--end::Avatar-->
                                    <!--begin::Details-->
                                    <div class="ms-3">
                                        <a href="javascript:void(0);" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">{{$contact->name}}</a>
                                        <span class="text-muted fs-7 mb-1">{{$replay->created_at ? $replay->created_at->diffForHumans() : ''}}</span>
                                    </div>
                                    <!--end::Details-->

                                </div>
                                <!--end::User-->

                                <!--begin::Text-->
                                <div class="p-5 rounded bg-light-info text-dark fw-semibold mw-lg-400px text-start" data-kt-element="message-text">
                                    {{$replay->message}}
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Message(in)-->


                            @endif

                        @endforeach







                       </div>
                    <!--end::Messages-->
                </div>
                <!--end::Card body-->
                <form method="POST" id="kt_inbox_reply_form" class="rounded border mt-10"
                      action="{{route('system.contacts.replay.send')}}">
                    @csrf
                <!--begin::Card footer-->
                <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                    <!--begin::Input-->
                    <textarea class="form-control form-control-flush mb-3" name="message" rows="1" data-kt-element="input" placeholder="ادخل الرسالة">
        </textarea>
                    <input type="hidden" name="contact_id" value="{{$contact->id}}">
                    <!--end::Input-->

                    <!--begin:Toolbar-->
                    <div class="d-flex flex-stack">
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center me-2">
{{--                            <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" aria-label="Coming soon" data-bs-original-title="Coming soon" data-kt-initialized="1"><i class="bi bi-paperclip fs-3"></i></button>--}}
{{--                            <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" aria-label="Coming soon" data-bs-original-title="Coming soon" data-kt-initialized="1"><i class="bi bi-upload fs-3"></i></button>--}}
                        </div>
                        <!--end::Actions-->

                        <!--begin::Send-->
                        <button class="btn btn-primary" type="submit" data-kt-element="send">ارسال</button>
                        <!--end::Send-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                </form>
                <!--end::Card footer-->
            </div>
        </div>

    </div>

@endsection
