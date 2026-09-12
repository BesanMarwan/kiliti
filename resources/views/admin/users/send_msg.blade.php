@extends('layouts.admin')
@section('title',lng('dashboard.sms.sms'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')">
        <x-header.breadcrumb-item :href="route('system.users.index')" :name="lng('dashboard.users.users')"/>
        <x-header.breadcrumb-item  :name="lng('dashboard.users,send_sms','ارسال رسالة نصية')"/>

    </x-header.title>
@endsection
@section('content')
    <form id="editForm" method="POST" action="{{route('system.users.sendMsg',['id'=>$user->id])}}" class="form">
        @csrf
        <x-theme.card>

            <div class="row justify-content-center">
                <div class="col-md-9">
                    <x-inputs.area required name="message" :title="lng('dashboard.general.message')" rows="5" :placeholder="lng('dashboard.users,enterMsg','ادخل النص')"/>
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
