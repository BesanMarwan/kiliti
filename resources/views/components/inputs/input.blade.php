@props([
    'disabled' => false,
    'title'=>'',
    'name'=>$attributes->wire('model')->value()??'',
    'hint'=>'',
    'type'=>'text',
    'placeholder'=>'',
    'isrequired'=>false
    ])

<div class="fv-row mb-7 relative @error($name) fv-plugins-bootstrap5-row-invalid has_error @enderror">
    <!--begin::Label-->
    <label class="{{$attributes->has('required')||$isrequired?'required':''}} fw-bold fs-6 mb-2">{{$title}}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <input
        @if($type=='date')data="has_date_picker" @else type="{{$type?:'text'}}" @endif
        @if($isrequired) required @endif
        {{ $disabled ? 'disabled' : '' }}
        {!! $attributes->merge(['class' => 'form-control form-control-solid mb-3 mb-lg-0']) !!}
        name="{{$name}}"
        value="{{old($name,isset($value)?$value:null)}}"
        placeholder="{{$placeholder?:$title}}"
        style="min-height: 43px;"  />
    <!--end::Input-->
    <span class="spinner-border spinner-border-sm align-middle ms-2 wire-loading" wire:loading.class="custom_show"  wire:target="{{$name}}"></span>
    @if($hint)<span class="form-text text-muted">{{$hint}}</span>@endif
    @error($name)
    <div class="fv-plugins-message-container invalid-feedback help-block JS_error has-error">
        {{ $message }}
    </div>
    @enderror
    <span class="JS_error fv-plugins-message-container invalid-feedback help-block has-error has-error">
    </span>
</div>
