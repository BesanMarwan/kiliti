@extends('layouts.admin')
@section('title','الرسائل النصية')
@section('page_title')
    <x-header.title name="لوحة التحكم">
        <x-header.breadcrumb-item :href="route('system.sms.index')" name="الرسائل النصية"/>
        <x-header.breadcrumb-item  name="ارسال رسالة نصية"/>

    </x-header.title>
@endsection
@section('content')
    <form id="editForm" action="{{route('system.sms.send')}}" class="form" method="post">
        @csrf
        <x-theme.card>

            <div class="row justify-content-center">
                <div class="col-md-9">
{{--                    <x-inputs.select name="notify_type"  id="" required :title="lng('dashboard.general.notify_type','الفئة المستهدفة')"  :options="\App\Models\SMS::getTypeArray()"/>--}}

                    <x-inputs.area required name="message" :title="lng('dashboard.general.message','الرسالة')" rows="5" :placeholder="lng('dashboard.general.message','الرسالة')"/>
                </div>
                <div class="w-100"></div>
                <div class="col-md-5">
                    <x-button class="w-100 btn-save" data-closemodal="#OpenModal_2">
                        <span class="svg-icon svg-icon-2"><x-lineawesome-check-solid/></span>@lng('dashboard.general.send','ارسال')

                    </x-button>
                </div>

            </div>


        </x-theme.card>

    </form>

@endsection
@push('js')
    <script src="{{asset('assets/custom/ar_MA.js')}}"></script>
    <script>
        const form = document.querySelector('#editForm');
        var validator = FormValidation.formValidation(
            form,
            {
                // fields: {
                //     'name': {
                //         validators: {
                //             notEmpty:{}
                //         }
                //     },
                // },
                locale: 'ar_MA',
                localization: ArabicLang,

                plugins: {
                    declarative: new FormValidation.plugins.Declarative({
                        html5Input: true,
                    }),
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    }),

                    icon: new FormValidation.plugins.Icon({
                        valid: 'fa fa-check',
                        invalid: 'fa fa-times',
                        validating: 'fa fa-refresh',
                    }),
                }
            }
        );
        const submitButton = form.querySelector('[data-kt-action="submit"]');
        submitButton.addEventListener('click', e => {
            e.preventDefault();
            if (validator) {
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;
                        form.submit();
                    }
                });
            }

        });

    </script>
@endpush
