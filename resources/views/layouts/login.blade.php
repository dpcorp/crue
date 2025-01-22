<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/images/app/CRUE.png') }}" />
    <meta name="title" content="CRUE ">
    <meta name="description" content="Centro Regulador de Urgencias, Emergencias y Desastres">
    <meta name="keywords" content="Centro Regulador de Urgencias, Emergencias, Desastres">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="Spanish">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CRUE</title>
    <link href="{{ asset('assets/css/lib/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('assets/css/lib/fontawesome/css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/lib/fontawesome/css/brands.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/lib/fontawesome/css/solid.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/app/login.css') }}" />

    <script type="text/javascript" src="{{ asset('assets/js/lib/sweetalert2@11.js') }}"></script>

</head>

<body class="bg-light no-scrollbar">
    @yield('content')
    <script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
</body>

</html>
