<div class="fv-row d-flex flex-wrap flex-center mb-7">
    <!--begin::Label-->
    <label class="d-block fw-bold fs-6 mb-5 w-100 text-center">{{$title}}</label>
    <!--end::Label-->
    <!--begin::Image input-->
    <div class="image-input image-input-outline" data-kt-image-input="true"
         style="background-image: url({{asset('uploads/blank.png')}})">
        <!--begin::Preview existing avatar-->
        <div class="image-input-wrapper w-125px h-125px"
             style="background-image: url({{asset('uploads/blank.png')}});"></div>
        <!--end::Preview existing avatar-->
        <!--begin::Label-->
        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
               data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل الصورة">
            <i class="bi bi-pencil-fill fs-7"></i>
            <!--begin::Inputs-->
            <input type="file" {{$attributes}} accept=".png, .jpg, .jpeg"/>
            <input type="hidden" name="avatar_remove"/>
            <!--end::Inputs-->
        </label>
        <!--end::Label-->
        <!--begin::Cancel-->
        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
              data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="حذف الصورة">
            <i class="bi bi-x fs-2"></i>
        </span>
        <!--end::Cancel-->
        <!--begin::Remove-->
        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
              data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="حذف الصورة">
            <i class="bi bi-x fs-2"></i>
        </span>
        <!--end::Remove-->
    </div>
    <!--end::Image input-->
    <!--begin::Hint-->
    <div class="form-text">الانواع المسموحة: png, jpg, jpeg.</div>
    <!--end::Hint-->
</div>
