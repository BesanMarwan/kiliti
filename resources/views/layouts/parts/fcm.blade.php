
<audio id="PlAyAuDiO123" src="{{asset('juntos-607.mp3')}}" autostart="false" ></audio><script type="module">

    // Import the functions you need from the SDKs you need

    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.9.2/firebase-app.js";

    import { getMessaging,getToken,onMessage } from "https://www.gstatic.com/firebasejs/9.9.2/firebase-messaging.js";


    // Initialize the Firebase app in the service worker by passing in
    // your app's Firebase config obsject.
    // https://firebase.google.com/docs/web/setup#config-object


    var firebaseConfig = {
        apiKey: "AIzaSyC-wsgqBjbAoxThChr7B0uXZrP_kZ28k90",
        authDomain: "lucerge.firebaseapp.com",
        databaseURL: "https://lucerge-default-rtdb.europe-west1.firebasedatabase.app",
        projectId: "lucerge",
        storageBucket: "lucerge.appspot.com",
        messagingSenderId: "781355161463",
        appId: "1:781355161463:web:bd77c76a67b97a29ecf372",
        measurementId: "G-P43ENG5ZQ8"
    };


    // Initialize Firebase
    const firebase = initializeApp(firebaseConfig);

    // firebase.initializeApp(firebaseConfig);
    // firebase.analytics();


    // Retrieve an instance of Firebase Messaging so that it can handle background
    // messages.
    const messaging = getMessaging(firebase);

    function initFirebaseMessagingRegistration() {
        getToken(messaging)
            .then(function(token) {
                // console.log(token);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route("admin.save_token") }}',
                    type: 'POST',
                    data: {
                        token: token
                    },
                    dataType: 'JSON',
                    success: function (response) {

                    },
                    error: function (err) {
                        console.log('User Chat Token Error'+ err);
                    },
                });
            }).catch(function (err) {
            console.log('User Chat Token Error'+ err);
        });
    }
    onMessage(messaging,function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon:payload.notification.image?payload.notification.image:"{{asset('notification.png')}}"
        };
        //
        var sound = document.getElementById("PlAyAuDiO123");
        sound.play();

        if(payload.notification.link){
            new Notification(noteTitle, noteOptions).onclick = function(event) {
                event.preventDefault(); // prevent the browser from focusing the Notification's tab
                window.open(payload.notification.link, '_blank');
            };
        }else{
            new Notification(noteTitle, noteOptions)
        }
        updateNotificationsCount();

    });
    if(messaging){
        initFirebaseMessagingRegistration();
    }


</script>
