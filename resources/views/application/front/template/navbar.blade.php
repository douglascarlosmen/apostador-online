<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{asset('img/logo-apostador.png')}}" width="160" alt="">
          </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Inicio</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/gerador">Gerador</a>
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
