@extends('layouts.admin')
@section('page_title')
    <x-header.title name="lng('dashboard.general.dashboard')">
        <x-header.breadcrumb-item :href="route('system.admins.index')" :name="lng('dashboard.general.Management')"/>
        <x-header.breadcrumb-item :name="lng('dashboard.general.add_new_admin')"/>

    </x-header.title>
@endsection
@section('content')
    <form id="editForm" class="form" method="post" action="{{route('system.admins.store')}}">
        @csrf
    <x-theme.card>

        <div class="row justify-content-center">
            <div class="col-md-9 row">
                <div class="col-md-6">
                    <x-inputs.input name="name" :value="old('name')" required :placeholder="lng('dashboard.general.Name')" :title="lng('dashboard.general.Name')" />
                </div>
                <div class="col-md-6">
                    <x-inputs.input name="mobile" value="{{old('mobile')}}"  :placeholder="lng('dashboard.general.Mobile')" :title="lng('dashboard.general.Mobile')" />
                </div>
                <div class="col-md-6">
                    <x-inputs.input name="email" :value="old('email')" required :placeholder="lng('dashboard.admins.email')" :title="lng('dashboard.admins.email')" />
                </div>
                <div class="col-md-6">
                    <x-inputs.input name="password" :value="old('password')" required type="password" :placeholder="lng('dashboard.general.Password')" :title="lng('dashboard.general.Password')" />
                </div>
                <div class="mb-7">

                    <label class="required fw-bold fs-6 mb-5">@lng('dashboard.admins.Role')</label>
                    @foreach($roles as $r)
                        <div class="d-flex fv-row">
                            <x-inputs.radio name="role_id" :value="$r->id" :checked="old('role_id')" :title="$r->name"/>

                        </div>
                        <div class='separator separator-dashed my-5'></div>
                    @endforeach


                </div>
            </div>
            <div class="col-3">
                <x-inputs.image name="image"  :title="lng('dashboard.general.image')"/>
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
