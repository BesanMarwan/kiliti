
<!--begin::Modal - Add task-->
<div class="modal fade" id="edit_model" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-1000px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="edit_model_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">{{$addTitle}}</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-edit-modal-action="close">
                    <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                <span class="svg-icon svg-icon-1">
                    <x-metronic-Close/>
                </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="kt_modal_edit__editform" class="editform" method="post" enctype="multipart/editform-data" action="{{old('url')}}">
                    @csrf
                    <input type="hidden" name="edited_id" value="{{old('edited_id',0)}}">
                    <input type="hidden" name="url" value="{{old('url')}}">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7"
                         id="edit_model_scroll"
                         data-kt-scroll="true"
                         data-kt-scroll-activate="{default: false, lg: true}"
                         data-kt-scroll-max-height="auto"
                         data-kt-scroll-dependencies="#edit_model_header"
                         data-kt-scroll-wrappers="#edit_model_scroll"
                         data-kt-scroll-offset="300px">
                        {{$slot}}
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-white me-3" data-kt-edit-modal-action="cancel">الغاء</button>
                        <button type="submit" class="btn btn-primary" data-kt-edit-modal-action="submit">
                            <span class="indicator-label">تعديل</span>
                            <span class="indicator-progress">الرجاء الانتظار...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Add task-->
<!--end::Add user-->

@push('js')
    <script src="{{asset('assets/custom/ar_MA.js')}}"></script>
    <script>
        const editelement = document.getElementById('edit_model');
        const editform = editelement.querySelector('#kt_modal_edit__editform');
          var editfvalidator = FormValidation.formValidation(
            editform,
            {
                // fields: {
                //     'name': {
                //         editfvalidators: {
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
        const edit_modal = new bootstrap.Modal(editelement);
        const editCancelButton = editelement.querySelector('[data-kt-edit-modal-action="cancel"]');
        editCancelButton.addEventListener('click', e => {
            e.preventDefault();

            Swal.fire({
                text: "هل أنت متأكد أنك تريد الإلغاء؟",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "نعم الغي العملية!",
                cancelButtonText: "لا ، رجوع",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    editform.reset(); // Reset editform
                    edit_modal.hide();
                }
            });
        });

        // Close button handler
        const editCloseButton = editelement.querySelector('[data-kt-edit-modal-action="close"]');
        editCloseButton.addEventListener('click', e => {
            e.preventDefault();

            Swal.fire({
                text: "هل أنت متأكد أنك تريد الإلغاء?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "نعم الغي العملية!",
                cancelButtonText: "لا ، رجوع",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    editform.reset(); // Reset editform
                    edit_modal.hide();
                }
            });
        });
        const editSubmitButton = editelement.querySelector('[data-kt-edit-modal-action="submit"]');
        editSubmitButton.addEventListener('click', e => {
            e.preventDefault();
            if (editfvalidator) {
                editfvalidator.validate().then(function (status) {
                    if (status == 'Valid') {
                        editSubmitButton.setAttribute('data-kt-indicator', 'on');
                        editSubmitButton.disabled = true;
                        editform.submit();
                    }
                });

            }

        });


        @if(count($errors->all()) && old('edited_id'))
        edit_modal.show();
        @endif

        $(function (){
            $('body').on('click','*[data-table-action="edit"]', function (e){
                e.preventDefault();
                let parentMenu=$(this).parents('td').find('.btn-menu');

                parentMenu.attr('data-kt-indicator', 'on').addClass('disabled')
                let url=$(this).data('url');
                $('#kt_modal_edit__editform input[name="edited_id"]').val($(this).data('id'));
                $('#kt_modal_edit__editform input[name="url"]').val(url);
                editform.setAttribute('action', url);
                editSubmitButton.disabled = true;
                $.get(url,

                    function (data, status) {
                        for ( dataKey in data.data) {
                            $('#kt_modal_edit__editform input[name="' + dataKey + '"]').val(data.data[dataKey]);
                            let search=['image','logo','icon'];
                            if(search.includes(dataKey.toLowerCase())&&data.data[dataKey]){
                                $('#kt_modal_edit__editform #Prev_' + dataKey ).attr('src',"{{url('uploads')}}/"+data.data[dataKey]);
                            }
                        }
                        parentMenu.attr('data-kt-indicator', 'off').removeClass('disabled')
                        editSubmitButton.setAttribute('data-kt-indicator', 'off');
                        editSubmitButton.disabled = false;
                        edit_modal.show();
                    }).fail(function (data2, status) {
                    var data2 = data2.responseJSON;
                    Swal.fire({
                        title: 'خطأ',
                        text: data2.response_message,
                        icon: 'error',
                        timer: 4000,
                        showConfirmButton: false
                    })
                });

            });
        })
    </script>
@endpush
