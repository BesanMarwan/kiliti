@extends('layouts.admin')
@section('title','الاشعارات')
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')">
        <x-header.breadcrumb-item :href="route('system.global_notifications.index')"  :name="lng('dashboard.global_notifications.global_notifications','الاشعارات')"/>
        <x-header.breadcrumb-item :name="lng('dashboard.global_notifications.new_notification','اضافة اشعار جديد')"/>

    </x-header.title>
@endsection
@section('content')
    <form id="editForm" action="{{route('system.global_notifications.store')}}" class="form" method="post">
        @csrf
        <x-theme.card>

            <div class="row justify-content-center">
                <div class="col-md-9">
                    <x-inputs.input required name="title" :title="lng('dashboard.global_notifications.title','العنوان')" :placeholder="lng('dashboard.global_notifications.EnterTitle','ادخل العنوان')"/>
                    <x-inputs.area required name="message" :title="lng('dashboard.global_notifications.text','النص')" row="4" :placeholder="lng('dashboard.global_notifications.EnterText','ادخل النص ')"/>
                </div>
                <div class="w-100"></div>
                <div class="col-md-5">
                    <x-button class="w-100 btn-save" data-closemodal="#OpenModal_2">
                        <span class="svg-icon svg-icon-2"><x-lineawesome-check-solid/></span>@lng('dashboard.general.add','اضافة')

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
