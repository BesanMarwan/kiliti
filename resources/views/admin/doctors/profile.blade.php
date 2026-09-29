@extends('layouts.admin')
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')">
        <x-header.breadcrumb-item :href="route('system.admins.index')" :name="lng('dashboard.general.Management')"/>
        <x-header.breadcrumb-item :name="lng('dashboard.general.edit_profile','تعديل بياناتي')"/>

    </x-header.title>
@endsection
@section('content')
    <form id="editForm" class="form" action="{{route('system.admins.do.profile')}}" method="post">
        @csrf
    <x-theme.card>

    <x-slot name="toolbar">
        <x-theme.button type="back">
            <span class="svg-icon svg-icon-2"><x-lineawesome-redo-solid/></span>@lng('dashboard.general.back')
        </x-theme.button>
        <x-theme.button type="submit">
            <span class="svg-icon svg-icon-2"><x-lineawesome-check-solid/></span>@lng('dashboard.general.edit')
        </x-theme.button>

    </x-slot>
        <div class="row">
            <div class="col-md-9 row">
                <div class="col-md-6">
                    <x-inputs.input required name="name" :value="$out->name" :placeholder="lng('dashboard.general.Name')" :title="lng('dashboard.general.Name')" />
                </div>
                <div class="col-md-6">
                    <x-inputs.input required name="mobile" :value="$out->mobile" :placeholder="lng('dashboard.general.Mobile')" :title="lng('dashboard.general.Mobile')" />
                </div>
                <div class="col-md-6">
                    <x-inputs.input required name="email" :value="$out->email" :placeholder="lng('dashboard.admins.email')" :title="lng('dashboard.admins.email')" />
                </div>
            </div>
            <div class="col-md-3 d-flex flex-wrap justify-content-center">
                <x-inputs.image name="image" :value="$out->image" :title="lng('dashboard.admins.image')" width="300" height="300"/>
                <x-theme.button type="href" :href="route('system.admins.profile.password')">
                    <span>@lng('dashboard.general.changePassword','تعديل كلمة المرور')</span>
{{--                    <x-lineawesome-user-lock-solid class="w-20px h-20px mx-3"/>--}}
                </x-theme.button>
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
