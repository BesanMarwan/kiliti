var err_msg = "حدثت مشكلة ، يرجى المحاولة مرة اخرى أو مراجعة الدعم الفني";
var success_msg = "تمت العملية بنجاح";
var block_submit=false;

function getModalContent(sourceUrl, modalWrapper, Title, modalSize, pageLoad) {
    $(modalWrapper + ' .modal-dialog').addClass(modalSize);
    $(modalWrapper).modal('show');
    $(modalWrapper).data('href',sourceUrl);

    $(modalWrapper + " .modal-title").html(Title);
    $(modalWrapper + " .modal-body").html("<h1 class='text-center p-7'>الرجاء الانتظار قليلا....</h1>");
    $.ajax({
        method: "GET",
        url: sourceUrl,
        data: {'IsModel': true}
    }).done(function (result) {
        loadModalData(modalWrapper,result)
        if($('.DropzoneCont').length){
            initDropZone($('.DropzoneCont').data('accept'));
        }
        if (typeof pageLoad !== undefined) {
            $(pageLoad).trigger("click");
            if ($(pageLoad).attr('data-bs-toggle') !== undefined)
                $(pageLoad).tab("show");
        }
    })
        .fail(function () {
            $(modalWrapper).modal('hide');
        });
}
function loadModalData(modalWrapper,result){
    var parsed = $.parseHTML(result, true);
    var ind1 = result.search("<div class=\"Custom_Modal_Scripts\">");
    var tm1=result.substring(ind1);
    var ind2 = tm1.search("</div>");
    var scripts=tm1.substring(0,ind2);


    result = $(parsed).find(".main-content");
    $(result).removeClass('container').removeClass('main-content');
    $(result).find('.card').addClass('card-flush  shadow-none');
    $(result).find('.btn-back').remove();
    // $(result).find('.card-header').remove();
    $(modalWrapper + " .modal-body").html(result);

    if ($(modalWrapper + " .modal-body"+' .select-input').length) {
        $(modalWrapper + " .modal-body"+' .select-input').select2({
            dir: 'rtl',
            dropdownParent: $(modalWrapper),
            width: 'resolve',
            placeholder: "الرجاء الاختيار",
            "language": {
                "noResults": function () {
                    return "لا يوجد نتائج";
                }
            },
        });
    }
    if(ind1 > 0){
        // console.log(scripts,modalWrapper,"#model-scripts-"+modalWrapper.slice(1),);
        $("#model-scripts-"+$(modalWrapper).attr('id')).html('').html(scripts);
    }else {
        $("#model-scripts-"+$(modalWrapper).attr('id')).html('');
    }


    KTMenu.createInstances();


}


function initDropZone(types){
    new Dropzone(".DropzoneCont", {
        url: UrlForScripts + '/uploadFilesDZ', // Set the url for your upload script location
        paramName: "uploaded_files", // The name that will be used to transfer the file
        uploadMultiple: true,
        maxFiles: 20,
        maxFilesize: 10, // MB
        addRemoveLinks: true,
        parallelUploads:20,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },

        acceptedFiles:types,
        // accept: function(file, done) {
        //     if (file.name == "wow.jpg") {
        //         done("Naha, you don't.");
        //     } else {
        //         done();
        //     }
        // }
    }).on("successmultiple", function(files, response) {
        block_submit=false;
        $('.DropzoneCont').parents('form').find('.uploaded_files_names').val(response.result);

    }).on("addedfile", file => {
        block_submit=true;
    });

}
$(document).on('click','.stopPropagation',function (e){
    e.stopPropagation();
})
$(document).on("click", ".OpenModal", function (e) {
    e.preventDefault();
    var title = $(this).attr("data-title");
    var href = $(this).attr("href");
    var modalSize = $(this).attr("data-size");
    var pageLoad = $(this).data('page-load');
    var level=$(this).attr("level")?$(this).attr("level"):1;
    getModalContent(href, "#OpenModal_"+level, title, modalSize, pageLoad);
});


function toast(type, message) {
    /* type = (error, info, warning, success) */
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-top-left",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    Command: toastr[type](message);
}

function Confirm(title, text, Confirmed, NotConfirme) {
    Swal.fire({
        title: title,
        text: text,
        icon: "info",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "<i class='las la-check-circle'></i> نعم ",
        cancelButtonText: '<i class="las la-times-circle"></i> لا',
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-default"
        }
    }).then(function (result) {
        if (result.isConfirmed) {
            Confirmed()
        } else if (result.dismiss == 'cancel') {
            NotConfirme()
        }
    })
}

var target = document.querySelector("#kt_content");

var blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> جاري التحميل...</div>',
});
$(document).on("click", ".search-btn", function (e) {
    e.preventDefault();
    e.stopPropagation();
    var formClass = ($(this).data('form-class') !== undefined) ? ("." + $(this).data('form-class')) : 'form';
    var form = ($(this).data('form-class') !== undefined) ? $(formClass) : $(this).parents('form');
    var data = {};
    form.serializeArray().map(function(x){data[x.name] = x.value;});



    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        contentType: false,
        processData: true,
        beforeSend: function () {
            blockUI.block();
        },
        data: data,
        success: function (result) {
            blockUI.release();
            var parsed = $.parseHTML(result, true);


        result = $(parsed).find(".main-content").html();
        $(document).find(".main-content").html(result);
            KTMenu.createInstances();
            initToggleToolbar();

            if ($(document).find('.select-input').length) {
                $(document).find('.select-input').select2({
                    dir: 'rtl',
                    width: 'resolve',
                    minimumResultsForSearch: 8,
                    placeholder: "الرجاء الاختيار",
                    "language": {
                        "noResults": function () {
                            return "لا يوجد نتائج";
                        }
                    },
                });
            }
        },
        error: function (jqXhr, json, errorThrown) {
            blockUI.release();
            var errors = jqXhr.responseJSON;
            if (jqXhr.status == 422) {
                $.each(errors.errors, function (key, value) {
                    var _tag = "input[name=" + key + "]";
                    var _tag2 = "select[name=" + key + "]";
                    $(_tag).addClass('fv-plugins-bootstrap5-row-invalid has_error');
                    $(_tag).siblings('.JS_error').html(value);
                    $(_tag2).addClass('fv-plugins-bootstrap5-row-invalid has_error');
                    $(_tag2).siblings('.JS_error').html(value);
                });
            }
        }
    });
});

$(document).on("click", ".clear-btn", function (e) {
    // e.preventDefault();
    // e.stopPropagation();
    var formClass = ($(this).data('form-class') !== undefined) ? ("." + $(this).data('form-class')) : 'form';
    var form = ($(this).data('form-class') !== undefined) ? $(formClass) : $(this).parents('form');
    var data = {};
    // form.serializeArray().map(function(x){data[x.name] = x.value;});



    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        contentType: false,
        processData: true,
        beforeSend: function () {
            blockUI.block();
        },
        data: data,
        success: function (result) {
            blockUI.release();
            var parsed = $.parseHTML(result, true);


        result = $(parsed).find(".main-content").html();
        $(document).find(".main-content").html(result);
            KTMenu.createInstances();
            initToggleToolbar();
            if ($(document).find('.select-input').length) {
                $(document).find('.select-input').select2({
                    dir: 'rtl',
                    width: 'resolve',
                    minimumResultsForSearch: 8,
                    placeholder: "الرجاء الاختيار",
                    "language": {
                        "noResults": function () {
                            return "لا يوجد نتائج";
                        }
                    },
                });
            }
        },
        error: function (jqXhr, json, errorThrown) {
            blockUI.release();
            var errors = jqXhr.responseJSON;
            if (jqXhr.status == 422) {
                $.each(errors.errors, function (key, value) {
                    var _tag = "input[name=" + key + "]";
                    var _tag2 = "select[name=" + key + "]";
                    $(_tag).addClass('fv-plugins-bootstrap5-row-invalid has_error');
                    $(_tag).siblings('.JS_error').html(value);
                    $(_tag2).addClass('fv-plugins-bootstrap5-row-invalid has_error');
                    $(_tag2).siblings('.JS_error').html(value);
                });
            }
        }
    });
});


$(document).on("click", ".btn-save", function (e) {
    e.preventDefault();
    e.stopPropagation();
    if(block_submit){
        Swal.fire({
            toast:true,
            text: 'الرجاء انتظار تحميل الملفات',
            timer: 3000,
            position:'bottom-start',
            timerProgressBar: true,
            showConfirmButton: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            },
            customClass: {
                container: 'm-2 p-0',
                header: 'm-0 p-0',
                content: 'm-0 p-0',
                htmlContainer: 'm-0 p-0',
            }
        })
        return;
    }
    var formClass = ($(this).data('form-class') !== undefined) ? ("." + $(this).data('form-class')) : 'form';
    var pageLoad = $(this).data('page-load'); // the id of button to click when done
    var redirect = $(this).data('redirect');// the redirect url if you want to redirect after complete
    var modal_to_close = $(this).data('closemodal');
    var messageConfirm = (typeof $(this).data('msg-confirm') !== undefined) ? $(this).data('msg-confirm') : 'هل أنت متأكد أنك تريد تنفيذ هذه العملية';
    var form = ($(this).data('form-class') !== undefined) ? $(formClass) : $(this).parents('form');
    var file = null;
    var btn = $(this);

    // if (form.find('input[type=file]').length && $('input[type=file]').files[0]) {
    //         file = $('input[type=file]').files[0];
    //         form.append('file', file);
    // }
    var formData = new FormData(form[0]);
    formData.append('is_ajax',1)


    $("*").removeClass('is-invalid');
    $(formClass+" .JS_error").html('');
    $(formClass+" .invalid-feedback").remove();
    const formV = document.querySelector("#"+form.attr('id'));

    var validator = FormValidation.formValidation(
        formV,
        {
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


    validator.validate().then(function (status) {
        if (status == 'Valid') {

            Confirm('رسالة تأكيد', messageConfirm,
                function () {
                    btn.attr('data-kt-indicator', 'on');
                    btn.attr('disabled', 'disabled');
                    $.ajax({
                        url: form.attr("action"),
                        type: form.attr("method"),
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            //console.log( this.data );
                        },
                        data: formData,
                        success: function (json) {
                            if( redirect && ValidURL(redirect)){
                                // swal.fire('')
                                return location.replace(redirect);
                            }
                            ReloadMe('only_back').then(function (){
                                if (typeof modal_to_close !== undefined)         // use this if you are using id to check
                                {
                                    btn.attr('data-kt-indicator', 'off');
                                    btn.removeAttr('disabled');
                                    $(modal_to_close).modal('hide');
                                }
                                if (typeof pageLoad !== undefined)         // use this if you are using id to check
                                {
                                    $(pageLoad).trigger("click");
                                }
                            });

                        },
                        error: function (jqXhr, json, errorThrown) {
                            btn.attr('data-kt-indicator', 'off');
                            btn.removeAttr('disabled');
                            var errors = jqXhr.responseJSON;
                            if (jqXhr.status == 422) {
                                let error='<ul class="text-right" style="padding:0 20px;">';
                                $.each(errors.errors, function (key, object) {
                                    var _tag = "input[name=" + object.field + "]";
                                    var _tag2 = "select[name=" + object.field + "]";
                                    $(_tag).addClass('fv-plugins-bootstrap5-row-invalid has_error');
                                    $(_tag).siblings('.JS_error').html(object.error);
                                    $(_tag2).addClass('fv-plugins-bootstrap5-row-invalid has_error');
                                    $(_tag2).siblings('.JS_error').html(object.error);
                                    error+='<li>'+object.error+'</li>';
                                });

                                error+='</ul>';
                                Swal.fire({
                                    toast:true,
                                    html: error,
                                    timer: 30000,
                                    position:'bottom-start',
                                    timerProgressBar: true,
                                    showConfirmButton: false,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    },
                                    customClass: {
                                        container: 'm-0 p-0',
                                        footer: 'm-0 p-0',
                                        content: 'm-0 p-0',
                                        htmlContainer: 'm-0 p-0',
                                    }
                                })
                            }
                        }
                    });
                },
                function () {

                }
            );
        }
    });


});

$(document).on('click','.pagination .page-link',function (e){
    e.preventDefault();
    e.stopPropagation();

    ReloadMe('back',$(this).attr('href'));

})
function AjaxRequest(type, ajaxurl, formData, successCallback, errorCallback) {
    $.ajax({
        type: type,
        url: ajaxurl,
        data: formData,
        dataType: 'json',
        success: successCallback,
        error: errorCallback
    });
}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    complete: function (result, textStatus) {
        if (result.status == 200) {
            if (isJson(result.responseText)) {
                var data = JSON.parse(result.responseText);
                if (data.hasOwnProperty("message")) {
                    toast("success", data.message);
                }
            }
        }
            // else  if(result.status == 500 ){
            //     var data = JSON.parse(result.responseText);
            //     if(data.hasOwnProperty("message")) {
            //         toast("error", data.message);
            //     }
        // }
        else if (result.status == 422) {
            //validation error
        } else if (result.status == 403) {
            var data = JSON.parse(result.responseText);
            if (data.hasOwnProperty("message")) {
                toast("error", data.message);
            }
        } else {
            toast("error", err_msg);
        }
    }
});

function ReloadMe(type='all',url=''){
    return new Promise(function(myResolve, myReject) {
// "Producing Code" (May take some time)

        blockUI.block();
        if(type==='all'){
            if($('.modal.show').data('href')){
                $.ajax({
                    method: "GET",
                    url: $('.modal.show').data('href'),
                    data: {'IsModel': true}
                }).done(function (result) {
                    loadModalData('.modal.show',result)
                }).fail(function () {
                });
            }
        }
        url=url?url:window.location.href;

        $.ajax({
            method: "GET",
            url: url,
            // data: {'IsModel': true}
        }).done(function (result) {
            var parsed = $.parseHTML(result, true);


            result = $(parsed).find(".main-content").html();
            $(".main-content").html(result);
            blockUI.release();

            if ($('.select-input').length) {
                $('.select-input').select2({
                    dir: 'rtl',
                    width: 'resolve',
                    placeholder: "الرجاء الاختيار",
                    "language": {
                        "noResults": function () {
                            return "لا يوجد نتائج";
                        }
                    },
                });
            }
            KTMenu.createInstances();
            initToggleToolbar();

            myResolve();
        }).fail(function () {
            blockUI.release();
            myReject();
        });
    });
}

