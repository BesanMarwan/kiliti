<script>

    $('#NotificationBill').click(function (e) {

        updateNotifications();
    });


    function updateNotificationsCount() {
        $('#NotifcationsContainer').html('').hide();
        $('#NotificationLoading').show();
        $('#NoNotifications').hide();
        jQuery.ajax({
            url:"{{route('system.admins.get_notifications')}}",
            type: 'GET',
            data: {
                'only_count':1
            },
            beforeSend: function (XMLHttpRequest) {
                $('body').removeClass("loading");
            },
            success: function (data) {
                if (data.done == 1) {
                    $('#NotificationLoading').hide();
                    $('#NotificationCount').html(data.count);
                    if(data.count == 0){
                        $('#NoNotifications').show();
                    }
                }
            }
        });


    }
    function updateNotifications() {
        $('#NotifcationsContainer').html('');
        $('#NotificationLoading').show();

        jQuery.ajax({

            url:"{{route('system.admins.get_notifications')}}",
            type: 'GET',
            data: {},
            beforeSend: function (XMLHttpRequest) {
                $('body').removeClass("loading");
            },
            success: function (data) {
                if (data.done == 1) {
                    $('#NotificationLoading').hide();
                    $('#NotificationCount').html(data.count);
                    $('#NotifcationsContainer').html(data.items).show();
                    if(data.count == 0){
                        $('#NoNotifications').show();
                    }else{
                        $('#NoNotifications').hide();

                    }
                }
            }
        });


    }
</script>
