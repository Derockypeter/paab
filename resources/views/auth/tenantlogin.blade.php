<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}: - Login</title>
    <link rel="shortcut icon" href="{{ asset('/media/img/wcdFavicon.jpg') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">


    <link rel="stylesheet" href="{{ global_asset('css/materialize.min.css') }}">
    <link rel="stylesheet" href="{{ global_asset('css/paab.css') }}">
    <link rel="stylesheet" href="{{ global_asset('css/auth.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    <div id="app">
        <tenant-login />
    </div>
    
    <script src="{{ global_asset('js/app.js') }}"></script>
    <script src="{{ global_asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ global_asset('js/materialize.min.js') }}"></script>
    <script src="{{ global_asset('js/paab.js') }}"></script>
</body>
</html>