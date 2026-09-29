@extends('layouts.admin')
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')">
        <x-header.breadcrumb-item :href="route('system.admins.index')" :name="lng('dashboard.general.Management')"/>
        <x-header.breadcrumb-item :href="route('system.admins.profile')" :name="lng('dashboard.general.profile','بياناتي')"/>
        <x-header.breadcrumb-item :name="lng('dashboard.admins.changePassword','تعديل كلمة المرور')"/>

    </x-header.title>
@endsection
@section('content')
    <form id="editForm" class="form" action="{{route('system.admins.do.profile.password')}}" method="post">
        @csrf
    <x-theme.card>

    <x-slot name="toolbar">
        <x-theme.button type="back">
            <span class="svg-icon svg-icon-2"><x-lineawesome-redo-solid/>@lng('dashboard.general.back','رجوع')
        </x-theme.button>
        <x-theme.button type="submit">
            <span class="svg-icon svg-icon-2"><x-lineawesome-check-solid/></span>@lng('dashboard.general.edit','تعديل')
        </x-theme.button>

    </x-slot>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <x-inputs.input type="password" name="old_password"  :placeholder="lng('dashboard.general.EnterOldPassword','ادخل كلمة المرور الحالية')" :title="lng('dashboard.general.oldPassword','كلمة المرور الحالية')" />
            </div>
            <div class="w-100"></div>
            <div class="col-md-6">
                <x-inputs.input type="password" name="password"  :placeholder="lng('dashboard.admins.EnterNewPassword','ادخل كلمة المرور الجديدة')" :title="lng('dashboard/admins.NewPassword','كلمة المرور الجديدة')" />
            </div>
            <div class="col-md-6">
                <x-inputs.input type="password" name="password_confirmation"  :placeholder="lng('dashboard.admins.EnterNewPassword','ادخل كلمة المرور الجديدة')" :title="lng('dashboard/admins.NewPassword','تأكيد المرور الجديدة')" />
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
