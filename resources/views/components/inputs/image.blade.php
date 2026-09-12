@props([
    'title'=>'',
    'width'=>300,
    'height'=>300,
    'name'=>'',
    'value'=>null,
])
<div class="fv-row d-flex flex-wrap flex-center mb-7">
    <label class="d-block fw-bold fs-6 mb-5 w-100 text-center">
        {{$title}}
        <br>
        <small style="color: gray;text-align: center;">({{set_if($width,300)}}px * {{set_if($height,300)}}px)</small>
    </label>
    <div class="image-input image-input-outline" data-kt-image-input="true"
         style="background-image: url({{asset('uploads/blank.png')}})">
        <div class="image-input-wrapper w-125px h-125px"
             style="background-image: url({{asset('uploads/blank.png')}});">
            <img
                src="{{old($name, $value) ? url('uploads/' . old($name, $value)) : "https://dummyimage.com/$width x $height/dbdbdd/000000"}}"
                style="width: 100%;background: #fefefe;
height: 100%;
object-fit: contain;" class="image-preview" id="Prev_{{$name}}"
                alt="">
        </div>
        <!--begin::Label-->
        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"
               data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تعديل الصورة">
            <i class="bi bi-pencil-fill fs-7 img-icon"></i>
            <span class="spinner-border spinner-border-sm align-middle image-spiner" style="display: none"></span>
            <!--begin::Inputs-->
            <input type="file" class="upload_image" accept=".png, .jpg, .jpeg"/>

            <input type="hidden" name="avatar_remove"/>
            <!--end::Inputs-->
        </label>

        <input type="hidden" name="{{$name}}" class="final-input" value="{{old($name, $value)}}"/>
    </div>


</div>
@push('js')

@endpush
