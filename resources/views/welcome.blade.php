<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Souftrack</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/png">
    <script src="https://kit.fontawesome.com/2d432c3088.js" crossorigin="anonymous"></script>
    @vite('resources/css/app.css')




</head>

<body>
    <div id="app">

    </div>

    @vite(['resources/js/app.js'])

</body>

</html>
