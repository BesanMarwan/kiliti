<audio id="PlAyAuDiO123" src="{{asset('juntos-607.mp3')}}" autostart="false" ></audio>

<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>

    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    let permission_granted=false;
    Notification.requestPermission().then(function(permission) {
        permission_granted=permission==='granted';
    });

    var pusher = new Pusher('{{config('custom.pusher_auth_key')}}', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('admin_notifications');
    channel.bind('notification', function(data) {
        show_notification(data);
    });
    channel.bind('notification{{auth()->id()}}', function(data) {
        show_notification(data);
    });
    function show_notification(data){
        const noteTitle = data.title;
        const noteOptions = {
            body: data.message,
            icon:"{{asset('notification.png')}}"
        };

        //
        var sound = document.getElementById("PlAyAuDiO123");
        sound.play();

        if(permission_granted){
            if(data.link){
                new Notification(noteTitle, noteOptions).onclick = function(event) {
                    event.preventDefault(); // prevent the browser from focusing the Notification's tab
                    window.open(data.link, '_blank');
                };
            }else{
                new Notification(noteTitle, noteOptions)
            }
        }else{
            swal.fire({
                title: data.title,
                text: data.message,
                icon: 'info',
                timer: 10000,
                position:'top-start',
                toast:true,
                showConfirmButton: false,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
        }

        // updateNotificationsCount();
    }
</script>
