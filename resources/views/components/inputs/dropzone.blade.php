@props(['name'=>'','accept'=>'image/*'])

<div>
    <input type="hidden" name="{{$name}}" class="uploaded_files_names">
    <div class="dropzone DropzoneCont" data-accept="{{$accept}}" >
        <!--begin::Message-->
        <div class="dz-message needsclick">
            <!--begin::Icon-->
            <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
            <!--end::Icon-->

            <!--begin::Info-->
            <div class="ms-4">
                <h3 class="fs-5 fw-bolder text-gray-900 mb-1">ضع الملفات هنا او اضغط لرفع الملفات</h3>
                <span class="fs-5 fw-bold text-gray-400">الحد الاقصى للرفع 20 ملف</span>
            </div>
            <!--end::Info-->
        </div>
    </div>
</div>
