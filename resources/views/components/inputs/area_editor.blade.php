@props(['disabled' => false,'title'=>'','text'=>'','value'=>'','name'=>''])

<div class="fv-row mb-7  @error($name) fv-plugins-bootstrap5-row-invalid has_error @enderror" style="margin-bottom: 1rem;">
    <label class="{{$attributes->has('required')?'required':''}} fw-bold fs-6 mb-2"  for="{{$name}}">{{$title}} </label>

    <textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control form-control-solid mb-3 mb-lg-0 editor summernote']) !!} id="{{$name}}" name="{{$name}}">{{old($name,isset($value)?$value:null)}}</textarea>

    @error($name)
    <div class="fv-plugins-message-container invalid-feedback help-block has-error">
        {{ $message }}
    </div>
    @enderror

</div>
@push('js')
    <script>
        ClassicEditor
            .create( document.querySelector( '#{{$name}}' ), {

                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'fontSize',
                        'fontColor',
                        'alignment',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'indent',
                        'outdent',
                        '|',
                        'blockQuote',
                        'insertTable',
                        'mediaEmbed',
                        'undo',
                        'redo',
                        'exportPdf',
                        'exportWord'
                    ]
                },
                language: "{{strpos($name, '_en') === false?'ar':'en'}}",
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                },
                licenseKey: '',

            } )
            .then( editor => {
                window.editor = editor;








            } )

            .catch( error => {
                console.error( 'Oops, something went wrong!' );
                console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                console.warn( 'Build id: xcs2esji16m9-tqzhsy8f19xk' );
                console.error( error );
            } );


    </script>
@endpush
