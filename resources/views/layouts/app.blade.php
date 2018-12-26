<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}?1" rel="stylesheet">
    <link href="{{ asset('public/css/style.css') }}?1" rel="stylesheet">
    {{-- <link href="{{ asset('public/css/app.css') }}" rel="stylesheet"> --}}
    @if ( (isset($nouislider)) && ($nouislider) )
    <link href="{{ asset('public/css/nouislider.min.css') }}" rel="stylesheet">
    @endif

    <script>
    var APP_URL = {!! json_encode(url('/')) !!}
    </script>
</head>
<body>
    <div id="app" class="wrapper">
        <header>
            @include('layouts.navigation')
        </header>

        <main>
            @yield('content')
        </main>

        @guest
            @include('layouts.login-modal')
        @endguest

        @if (session()->has('productAdded'))
            @include('templates.product-added')
        @endif

        <footer>
            @include('layouts.footer')
        </footer>

        <div class="overlay"></div>
    </div>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <!-- 
        Scripts 
    -->
    <!--Load Page Scripts-->
    <script src="{{ asset('public/js/app.js') }}?1"></script>
    <script src="{{ asset('public/js/script.js') }}?1"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    @if (Auth::check() && Auth::user()->isAdmin())
        <script src="{{ asset('public/js/admin.js') }}"></script>
    @endif

    @yield('scripts')
</body>
</html>