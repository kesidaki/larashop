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
    {{-- <link href="{{ asset('css/minified.css') }}?1" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}?1" rel="stylesheet"> --}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @if ( (isset($nouislider)) && ($nouislider) )
    <link href="{{ asset('css/nouislider.min.css') }}" rel="stylesheet">
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

    <!-- 
        Scripts 
    -->
    <!--Load Page Scripts-->
    {{-- <script src="{{ asset('js/minified.js') }}?1"></script>
    <script src="{{ asset('js/script.js') }}?1"></script> --}}
    <script src="{{ mix('js/app.js') }}?1"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    @if (Auth::check() && Auth::user()->isAdmin())
        <!--Load Admin Scripts-->
        <script src="{{ asset('js/admin.js') }}"></script>
    @endif

    <!--Load NoUISlider-->
    @if ( (isset($nouislider)) && ($nouislider) )
        <script src="{{ asset('js/nouislider.min.js') }}"></script>
    @endif

    <!--Load ChartJS-->
    @if ( (isset($chart)) && ($chart) )
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    @endif

    <!--Lazy Load Page Scripts-->
    <script>
        var _scripts = document.getElementsByTagName("script"), _doc = document, _txt = "text/delayscript";

        for(var i=0,l=_scripts.length;i<l;i++){
            var _type = _scripts[i].getAttribute("type");
            if(_type && _type.toLowerCase() ==_txt)
            _scripts[i].parentNode.replaceChild((function(sB){
            var _s = _doc.createElement('script');
            _s.type = 'text/javascript';
            _s.innerHTML = sB.innerHTML;
            return _s;
            })(_scripts[i]), _scripts[i]);
        }
    </script>

    @if ( (isset($tinymce)) && ($tinymce) )
        <!--Load TinyMCE when needed-->
        <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
        <script>
            tinymce.init({ 
                selector:'.tinymce',
                entity_encoding: 'raw',
                theme: 'modern',
                image_advtab: true,
                toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link',
                plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
                ]
            });
        </script>
    @endif
</body>
</html>