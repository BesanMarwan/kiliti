@props([
    'name'=>'name',
    'value'=>'value',
    'title'=>'',
    'description'=>'',
    'id'=>$name.rand(0,9999),
    'style'=>''
])
<label class="form-check form-check-custom form-check-solid" style="cursor:pointer;{{$style}}">
    <!--begin::Input-->
    <input class="form-check-input me-3" name="{{$name}}" type="radio" value="{{$value}}"  id="{{$id}}"  @if(isset($checked)&&$checked)checked="checked"@endif {{$attributes}} />
    <!--end::Input-->
    <!--begin::Label-->
    <label class="form-check-label" for="{{$id}}">
        <div class="fw-bolder text-gray-800">{{$title}}</div>
        @if($description)
        <div class="text-gray-600">{{$description}}</div>
            @endif
    </label>
    <!--end::Label-->
</label>
