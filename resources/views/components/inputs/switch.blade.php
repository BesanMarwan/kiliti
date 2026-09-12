@props([
    'checked'=>false,
    'title'=>''
    ])
<div class="d-flex justify-content-center mt-2">

    <label class="form-check form-switch form-check-custom form-check-solid">
        <input class="form-check-input"  {{$attributes}} @if(isset($checked)&&$checked)checked="checked" @endif  type="checkbox" value="1" />
        <span class="form-check-label fw-semibold text-muted">
            {{$title}}
        </span>
    </label>

</div>
