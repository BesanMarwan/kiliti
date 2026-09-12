@props([
    'title'=>'',
    'name'=>'',
    'placeholder'=>'',
    'options'=>[],
])
<div {{$attributes}}>
    @if($title)
    <label class="form-label fs-6 fw-bold w-100">{{$title}}</label>
    @endif
    <select class="form-select form-select-solid fw-bolder w-100" style="width: 100%" name="{{$name}}" data-kt-select2="true" data-placeholder="{{$placeholder}}" data-allow-clear="true">
        <option></option>
        @foreach($options as $id=>$ob)
        <option value="{{isset($ob->id)?$ob->id:$id}}" {{request()->get($name) == (isset($ob->id)?$ob->id:$id)?'selected':''}}>{{isset($ob->name)?$ob->name:$ob}}</option>
        @endforeach
    </select>
</div>
