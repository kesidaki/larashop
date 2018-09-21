<nav class="navbar navbar-social navbar-expand-lg">
    <ul class="navbar-nav flex-row ml-auto">
        <li class="nav-item">
            <a class="nav-link py-1 pr-3" href="#"><i class="fab fa-facebook-f"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-1 pr-3" href="#"><i class="fab fa-twitter"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-1 pr-3" href="#"><i class="fab fa-instagram"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-1 pr-3" href="#"><i class="fab fa-linkedin-in"></i></a>
        </li>
    </ul>
</nav>
<nav class="navbar navbar-bordered navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('img/logo.png')}}"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse flex-column ml-lg-0 ml-3" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 ml-auto navbar-custom-top">
                <li class="nav-item">
                    <form class="form-inline my-2 my-lg-0" id="searchTermForm">
                        <input class="form-control no-br-right" type="search" placeholder="Προϊόν, Κατηγορία" aria-label="Αναζήτηση" id="search-term">
                        <button class="btn btn-success no-br-left my-2 my-sm-0 mx-auto" type="button"><i class="fas fa-search"></i><span class="d-sm-block d-md-none"> Αναζήτηση</span></button>
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-cart py-1 pr-3" href="{{url('cart')}}"><i class="fas fa-shopping-cart"></i> Καλάθι ({{Cart::count()}})</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto navbar-custom-bottom">
                <li class="nav-item nav-item-bordered active">
                    <a class="nav-link" href="{{ url('/') }}">Αρχική <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item nav-item-bordered">
                    <a class="nav-link" href="{{ url('products/videogames') }}">Βιντεοπαιχνίδια</a>
                </li>
                <li class="nav-item nav-item-bordered">
                    <a class="nav-link" href="{{ url('products/epitrapezia') }}">Επιτραπέζια</a>
                </li>
                <li class="nav-item nav-item-bordered">
                    <a class="nav-link" href="{{ url('products/accessories') }}">Αξεσουάρ</a>
                </li>
                @guest
                    <li class="nav-item">
                        <!--<a class="nav-link navbar-btn" href="{{ route('login') }}">Σύνδεση</a>-->
                        <a class="nav-link navbar-btn" data-toggle="modal" data-target="#loginModal">Σύνδεση</a>
                    </li>
                @else
                    <li class="nav-item nav-item-bordered dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <i class="fas fa-chevron-down"></i>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if (Auth::user()->admin == 'true')
                                <a class="dropdown-item" href="{{ url('admin/home') }}">Διαχείριση</a>
                            @endif
                            <a class="dropdown-item" href="{{ url('account/stoixeia-paradosis') }}">Στοιχεία Παράδοσης</a>
                            <a class="dropdown-item" href="{{ url('account/paraggelies') }}">Οι παραγγελίες μου</a>
                            <a class="dropdown-item" href="{{ url('account/allagi-kodikou') }}">Αλλαγή Κωδικού</a>
                            <a class="dropdown-item" href="{{ route('logout') }}">Αποσύνδεση</a>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>