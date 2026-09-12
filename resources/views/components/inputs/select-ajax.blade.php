@props([
    'title'=>'',
    'name'=>$attributes->wire('model')->value()??'',
    'placeholder'=>'',
    'options'=>[],
    'url'=>'',
])
@php
    $id=str_replace('.','_',$name).rand(1000,9999999);
@endphp

<div class="fv-row relative @error($name) fv-plugins-bootstrap5-row-invalid has_error @enderror">
    @if($title)
    <label class="form-label fs-6 fw-bold w-100 {{$attributes->has('required')?'required':''}}" for="{{$id}}"> {{$title}}</label>
    @endif
    <select  {{$attributes}} id="{{$id}}" class="form-select form-select-solid fw-bolder w-100" style="width: 100%" name="{{$name}}"   >

        @if(request()->get($name))
        <option value="{{request()->get($name)}}" selected="selected">{{request()->get($name)}}</option>
        @endif

    </select>
         <span class="spinner-border spinner-border-sm align-middle ms-2 wire-loading" wire:loading.class="custom_show"  wire:target="{{$name}}"></span>

    @error($name)
    <div class="fv-plugins-message-container invalid-feedback help-block has-error">
        {{ $message }}
    </div>
    @enderror
</div>
@push('js')
    <script>
        $('#{{$id}}').select2({
            ajax: {
                url: '{{$url}}',
                delay: 250,
                data: function (params) {
                    var query = {
                        name: params.term,
                        page: params.page || 1
                    }

                    // Query parameters will be ?search=[term]&page=[page]
                    return query;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    console.log(data)
                    return {
                        results: data.items,
                        pagination: {
                            more: data.more
                        }
                    };
                }
            },
            @if(!$attributes->has('required'))
            allowClear:true,
            @endif
            placeholder:"{{$placeholder}}"

        });

        var Selected_{{$id}} = $('#{{$id}}');
        $.ajax({
            type: 'GET',
            url:   '{{$url}}?id='+ Selected_{{$id}}.val(),
        }).then(function (data) {
            // create the option and append to Select2
            var option = new Option(data.text, data.id, true, true);
            Selected_{{$id}}.append(option).trigger('change');

            // manually trigger the `select2:select` event
            Selected_{{$id}}.trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            });
        });
    </script>

@endpush
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
