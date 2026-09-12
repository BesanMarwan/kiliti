@props([
    'disabled' => false,
    'title'=>'',
    'name'=>$attributes->wire('model')->value()??'',
    'value'=>'',
    'rows'=>8,
    'placeholder'=>'',
    ])

<div class="fv-row mb-7 relative  @error($name) fv-plugins-bootstrap5-row-invalid has_error @enderror">
    <!--begin::Label-->
    <label class="{{$attributes->has('required')?'required':''}} fw-bold fs-6 mb-2" for="{{$name}}">{{$title}}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <textarea
        {{ $disabled ? 'disabled' : '' }}
        {!! $attributes->merge(['class' => 'form-control form-control-solid mb-3 mb-lg-0']) !!}
        id="{{$name}}"
        name="{{$name}}"
        placeholder="{{$placeholder?:$title}}"
        rows ={{$rows}}
    >{{old($name,isset($value)?$value:null)}}</textarea>
    <!--end::Input-->
         <span class="spinner-border spinner-border-sm align-middle ms-2 wire-loading" wire:loading.class="custom_show"  wire:target="{{$name}}"></span>

    @error($name)
    <div class="fv-plugins-message-container invalid-feedback help-block has-error">
        {{ $message }}
    </div>
    @enderror
</div>
