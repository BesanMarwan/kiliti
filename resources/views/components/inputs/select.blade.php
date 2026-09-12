@props([
    'title'=>'',
    'name'=>$attributes->wire('model')->value()??'',
    'placeholder'=>'',
    'options'=>[],
    'isrequired'=>false,
    'value'=>''
])
<div class="fv-row mb-7 relative @error($name) fv-plugins-bootstrap5-row-invalid has_error @enderror">
    @if($title)
    <label class="form-label fs-6 fw-bold w-100 {{$attributes->has('required')||$isrequired?'required':''}}">{{$title}}</label>
    @endif
    <select
        {{$attributes}}
        id="{{str_replace('.','_',$name)}}"
        class="form-select form-select-solid fw-bolder w-100 select-input"
        style="width: 100%"
        name="{{$name}}"
        data-minimum-results-for-search="8"
        data-kt-select2="true"
        data-placeholder="{{$placeholder?:$title}}"
        @if(!$attributes->has('required')&&!$isrequired) data-allow-clear="true" @endif
    >
        <option></option>
        @foreach($options as $id=>$ob)
        <option value="{{isset($ob->id)?$ob->id:$id}}" {{request()->get($name,$value) == (isset($ob->id)?$ob->id:$id)?'selected':''}}>{{isset($ob->name)?$ob->name:$ob}}</option>
        @endforeach
    </select>
         <span class="spinner-border spinner-border-sm align-middle ms-2 wire-loading" wire:loading.class="custom_show"  wire:target="{{$name}}"></span>

    @error($name)
    <div class="fv-plugins-message-container invalid-feedback help-block has-error">
        {{ $message }}
    </div>
    @enderror
        <span class="JS_error fv-plugins-message-container invalid-feedback help-block has-error has-error">
    </span>
</div>

@if($attributes->wire('model')->value())
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            $('#{{str_replace('.','_',$name)}}').select2().on('change', function(e){
                // console.log(e.target.value)

                @this.set('{{$name}}', e.target.value);

            });
            Livewire.hook('message.processed', (message, component) => {
                // console.log('message.processed',message, component)
                $('#{{str_replace('.','_',$name)}}').select2().on('change', function(e){
                    // console.log(e.target.value)

                    @this.set('{{$name}}', e.target.value);
                });
            })
            {{--window.livewire.hook('message.processed', () => {--}}
            {{--    $('#{{$name}}').select2(config_{{$name}}).on('change', function(e){--}}
            {{--        console.log(e.target.value)--}}
            {{--        @this.set('{{$name}}', e.target.value);--}}
            {{--    });--}}
            {{--});--}}
        });
    </script>

@endpush
@endif
