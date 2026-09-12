<label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
    <input type="checkbox" {!! $attributes->merge(['class' => 'form-check-input']) !!} @if(isset($checked)&&$checked)checked="checked"@endif />
    <span class="form-check-label">{{$title}}</span>
</label>
