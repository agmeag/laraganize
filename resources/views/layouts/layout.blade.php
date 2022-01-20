<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laraganize</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/boxicons/css/boxicons.min.css">
    <script src="/js/boxicons.js"></script>
    <style>
        html,
        body,
        #app {
            width: 100%;
            height: 100%;
            min-height: 100%;
            min-width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
    </style>
</head>

<body>
    <div id="app">
        @yield('header')
        @yield('content')
        @yield('footer')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>