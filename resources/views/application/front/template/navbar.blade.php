<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{asset('img/logo-apostador.png')}}" width="160" height="80" alt="">
          </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">
                        Dia de Sorte
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/conferidor/dia-de-sorte">Conferidor</a>
                        @if (Auth::user())
                        <a class="dropdown-item" href="/gerador/dia-de-sorte">Gerador Automático</a>
                        @endif
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">
                        Lotofácil
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/conferidor/lotofacil">Conferidor</a>
                        @if (Auth::user())
                        <a class="dropdown-item" href="/gerador/lotofacil">Gerador Automático</a>
                        @endif
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">
                        Dupla-Sena
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/conferidor/dupla-sena">Conferidor</a>
                        @if (Auth::user())
                        <a class="dropdown-item" href="/gerador/dupla-sena">Gerador Automático</a>
                        @endif
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">
                        Lotomania
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/conferidor/lotomania">Conferidor</a>
                        @if (Auth::user())
                        <a class="dropdown-item" href="/gerador/lotomania">Gerador Automático</a>
                        @endif
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">
                        Mega-Sena
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/conferidor/mega-sena">Conferidor</a>
                        @if (Auth::user())
                        <a class="dropdown-item" href="/gerador/mega-sena">Gerador Automático</a>
                        @endif
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">
                        Quina
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/conferidor/quina">Conferidor</a>
                        @if (Auth::user())
                        <a class="dropdown-item" href="/gerador/quina">Gerador Automático</a>
                        @endif
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">
                        Timemania
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/conferidor/timemania">Conferidor</a>
                        @if (Auth::user())
                        <a class="dropdown-item" href="/gerador/timemania">Gerador Automático</a>
                        @endif
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav">
                @if (Auth::user())
                <form action="/logout" method="POST">
                    @csrf
                    <button class="btn nav-link">
                        Sair
                    </button>
                </form>
                @endif
            </ul>
        </div>
    </div>
</nav>
