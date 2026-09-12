@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <script>
            $('document').ready(function () {
                setTimeout(function() {
                    Swal.fire({
                        title: '{!! $message['message'] !!}',
                        {{--text: '{!! $message['message'] !!}',--}}
                        icon: '{{ $message['level'] }}',
                        timer: 8000,
                        position:'top-end',
                        toast:true,
                        showConfirmButton: false,
                        timerProgressBar: true,
                        onOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                }, {{isset($MESSDELAY)?$MESSDELAY:1}});
            });
        </script>
    @endif
@endforeach
{{ session()->forget('flash_notification') }}
