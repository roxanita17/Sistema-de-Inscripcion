@vite(["resources/css/home/Encabezado.css"])
    <header class="">
        <nav class="navbar  fixed-top navbar-expand-lg bg-primary" style="min-height: 96px;">
            <div class="container-fluid">

                <img class="logo-institucion" src="{{ asset('/images/comunidad/liceo_logo.png') }}" alt="image">



                        <h1>
                        Gral "Juan Guillermo Iribarren"
                    </h1>




                {{-- </a> --}}
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <ul class="navbar-nav">
                                <li><a class="nav-link" href="{{ route('home.principal') }}">Home</a></li>
                                <li><a class="nav-link" href="{{ route('home.vidaEstudiantil') }}">Vida estudiantil</a></li>
                                <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        {{-- </nav> --}}
    </header>
