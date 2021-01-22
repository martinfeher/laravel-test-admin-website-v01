<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/libs/bootstrap-4.5.3/css/bootstrap.css') }}" rel="stylesheet">
</head>
<body>

    <main class="main" id="top">
        <div class="container" data-layout="container">
{{--            @include('partials.side-menu')--}}
            <div class="content">
{{--                @include('partials.top-menu')--}}
                @yield('content')
            </div>
        </div>
    </main>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <link href="/css/master.css" rel="stylesheet">

    @yield('scripts')

</body>
</html>
