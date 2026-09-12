@props([
    'type'=>'href',
    'parentformclass'=>'',
    'btntoclick'=>'',
    'redirecturl'=>URL::previous(),
    'modalidtoclose'=>'OpenModal_1',

    'modaltitle'=>'',
    'modalsize'=>'modal-xl',
    'modallevel'=>'2',
])

@if(isset($type)&&$type == 'href')
    <a {{ $attributes->merge([ 'class' => 'btn btn-sm btn-flex btn-light-primary']) }} >{{$slot}}</a>

@elseif(isset($type)&&$type == 'openmodal')
    <a {{ $attributes->merge([ 'class' => 'btn btn-sm btn-flex btn-light-primary OpenModal']) }}
       data-title="{{$modaltitle}} "
       data-size="{{$modalsize}}"
       level="{{$modallevel}}"
    >{{$slot}}</a>

@elseif(isset($type)&&$type == 'back')
    <a {{ $attributes->merge([ 'class' => 'btn btn-sm btn-link text-gray-400 mx-4']) }} href="{{URL::previous()}}">{{$slot}}</a>

@elseif(isset($type)&&$type == 'submit')
    <button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-sm btn-flex btn-light-primary btn-save']) }}
            data-form-class="{{$parentformclass}}"
            data-page-load="{{$btntoclick}}"
            data-redirect="{{$redirecturl}}"
            data-closemodal="{{$modalidtoclose}}"
            data-kt-action="submit">
        <span class="indicator-label">{{$slot}}</span>
        <span class="indicator-progress">الرجاء الانتظار...
        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
    </button>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-sm btn-flex btn-light-primary']) }} >{{$slot}}</button>

@endif
