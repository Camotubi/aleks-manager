<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css" {{-- {{asset('css/app.css')}}" --}} rel="stylesheet" type="text/css">
        <link href="{{asset('css/mail.css')}}" rel="stylesheet" type="text/css">
    </head>

    <body>
        <section>
            @yield('content')
        </section>
    </body>
</html>


