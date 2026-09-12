@props([
    'disabled' => false,
    'title'=>'',
    'name'=>$attributes->wire('model')->value()??'',
    'hint'=>'',
    'type'=>'text',
    'placeholder'=>'',
    'value'=>'',
    'isrequired'=>false
    ])

<div class="fv-row mb-7 relative @error($name) fv-plugins-bootstrap5-row-invalid has_error @enderror">
    <!--begin::Label-->
    <label class="fw-bold fs-6 mb-2">{{$title}}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <div

        {!! $attributes->merge(['class' => 'form-control form-control-solid mb-3 mb-lg-0']) !!}
        style="min-height: 43px;"  >{{old($name,isset($value)?$value:null)}}</div>
    <!--end::Input-->
    @if($hint)<span class="form-text text-muted">{{$hint}}</span>@endif
</div>
