@extends('layouts.admin')
@section('title',lng('dashboard.general.settings'))
@section('page_title')
    <x-header.title :name="lng('dashboard.general.dashboard')">
        <x-header.breadcrumb-item :name="lng('dashboard.general.settings')"/>

    </x-header.title>
@endsection
@section('content')
    <form id="editForm" method="post" class="form" action="{{route('system.settings.save')}}">
        @csrf
        @foreach($settings as $key=>$array)
            <div class="card my-5">
                <div class="card-header  pt-7">
                    <span class="card-label fw-bolder fs-3 mb-1">{{lang('settings.tabs.'.$key)}}</span>
                </div>
                <div class="card-body pt-6">
                    <div class="row justify-content-center">
                        @foreach($array as $setting)
                            @if( $setting->name!= 'app_status_android' && $setting->name != 'app_status_ios')

                                <div class="col-md-6">
                                    <x-inputs.input :name="$setting->name" :value="$setting->value" :title="lang('settings.items.'.$setting->name)"/>
                                </div>


                            @else

                                <div class="col-md-6 mb-5">
                                    <div class="form-group row">
                                        <label class=" fw-bold fs-6 mb-2 ">{{lang('settings.items.'.$setting->name)}}</label>
                                        <div class="col-6 mt-2">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input name="{{$setting->name}}" class="form-check-input" type="checkbox" value="1"  @if($setting->value == 1)checked="checked" @endif/>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

        @endforeach

        <div class="row justify-content-center my-5 ">
            <div class="col-md-4"></div>
            <div class="col-md-12 row text-center m-auto">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <x-theme.button type="submit"  class="text-center pr-5">
                        <span class="svg-icon svg-icon-2"><x-lineawesome-check-solid/></span>@lng('dashboard.general.edit')
                    </x-theme.button>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
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
