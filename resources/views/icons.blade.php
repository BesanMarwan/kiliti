<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Icons</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

</head>
<body>

<div class="container-fluid mt-5">
    <div class="alert">
        please use : php artisan icons:cache to refresh
    </div>

    @foreach($icons as $key=>$folders)
        <div class="card">
            <h3 class="card-title text-center">{{$key}}</h3>
            <div class="card-body d-flex justify-content-center flex-wrap">
                @foreach($folders as $folder)

                    @foreach($folder as $icon)
                        <div style="margin: 5px;padding: 10px;border:2px solid #ddd;border-radius: 5px;text-align: center;width: 15%;">
                            @svg($key.'-'.$icon)
                            <p>{{'<'}}x-{{$key}}-{{$icon}}{{'/>'}}</p>
                            <p>{{'@'}}svg("{{$key.'-'.$icon}}")</p>
                        </div>


                    @endforeach

                @endforeach

            </div>
        </div>

    @endforeach

</div>
</body>
</html>
