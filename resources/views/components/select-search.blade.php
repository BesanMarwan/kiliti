@props([
    'title'=>'',
    'name'=>$attributes->wire('model')->value()??'',
    'placeholder'=>'',
    'options'=>[],
])

<div class="d-flex align-items-center position-relative w-200px my-1">

    <select  {{$attributes}}  id="{{str_replace('.','_',$name)}}" class="form-select form-select-solid fw-bolder w-100 select-input" style="width: 100%" name="{{$name}}" data-kt-select2="true" data-placeholder="{{$placeholder}}" title="{{$placeholder}}" data-minimum-results-for-search="8" @if(!$attributes->has('required')) data-allow-clear="true" @endif>
        <option {{!request()->has($name) ?'selected':''}}></option>
        @foreach($options as $id=>$ob)
            <option value="{{isset($ob->id)?$ob->id:$id}}" {{request()->get($name) === (isset($ob->id)?$ob->id:$id)?'selected':''}}>{{isset($ob->name)?$ob->name:$ob}}</option>
        @endforeach
    </select>
</div>
