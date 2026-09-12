@extends('layouts.admin')
@section('title',lng('dashboard.general.roles','الصلاحيات'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')">
        <x-header.breadcrumb-item :href="route('system.roles.index')" :name="lng('dashboard.general.roles','الصلاحيات')"/>
        <x-header.breadcrumb-item :name="lng('dashboard.general.edit_roles','تعديل الصلاحية')"/>

    </x-header.title>
@endsection
@section('content')
    <form id="editForm" class="form" method="post">
        @csrf
    <x-theme.card>

    <x-slot name="toolbar">
        <x-theme.button type="back">
            <span class="svg-icon svg-icon-2"><x-lineawesome-redo-solid/></span>@lng('dashboard.general.back','رجوع')
        </x-theme.button>
        <x-theme.button type="submit">
            <span class="svg-icon svg-icon-2"><x-lineawesome-check-solid/></span>@lng('dashboard.general.update','تعديل')
        </x-theme.button>

    </x-slot>
    <!--begin::Input group-->
        <x-inputs.input required name="name" :value="$out->name" :title="lng('dashboard.roles.role_name','اسم الصلاحية')" :placeholder="lng('dashboard.roles.role_name','اسم الصلاحية')"/>
        <!--end::Input group-->
        <!--begin::Permissions-->
        <div class="fv-row">
            <!--begin::Label-->
            <label class="fs-5 fw-bolder form-label mb-2">@lng('dashboard.roles.roles','الصلاحيات')</label>
            <!--end::Label-->
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5">
                    <!--begin::Table body-->
                    <tbody class="text-gray-600 fw-bold">

                    <tr>
                        <td class="text-gray-800">
                            @lng('dashboard.roles.all_roles','جميع الصلاحيات')
                            <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="{{lng('dashboard.roles.all_control','اسمح بتحكم كامل بالنظام')}}"></i></td>
                        <td>
                            <!--begin::Checkbox-->
                            <label class="form-check form-check-custom form-check-solid me-9">
                                <input class="form-check-input" type="checkbox" value="" id="kt_roles_select_all" />
                                <span class="form-check-label" for="kt_roles_select_all">@lng('dashboard.roles.select_all','اختر الجميع')</span>
                            </label>
                            <!--end::Checkbox-->
                        </td>
                    </tr>
                    @foreach($permissions as $module=>$perms)
                    <tr>

                        <td class="text-gray-800">{{lang('permissions.modules.'.$module)}}</td>

                        <td>

                            <div class="d-flex">
                                @foreach($perms as $pp=>$id)
                                <x-inputs.checkbox name="permissions[]" :checked="$out->hasPermissionTo($id)"  :value="$id" :title="lang('permissions.roles.'.$pp)" />
                                @endforeach

                            </div>

                        </td>

                    </tr>
                    @endforeach


                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Permissions-->
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
        const handleSelectAll = () => {
            // Define variables
            const selectAll = form.querySelector('#kt_roles_select_all');
            const allCheckboxes = form.querySelectorAll('[type="checkbox"]');

            // Handle check state
            selectAll.addEventListener('change', e => {

                // Apply check state to all checkboxes
                allCheckboxes.forEach(c => {
                    c.checked = e.target.checked;
                });
            });
        }
        handleSelectAll();
    </script>
@endpush
