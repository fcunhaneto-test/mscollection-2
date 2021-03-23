<nav class="navbar is-primary navbar-frontend" role="navigation" aria-label="main navigation">
    <div class="container is-max-widescreen">
        <div class="navbar-brand">
            <a class="navbar-item" href="/">{{ config('app.name', 'Laravel') }}</a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false"
               data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link dropdown-title">Filmes</a>

                    <div class="navbar-dropdown">
                        @foreach($media as $m)
                            <a class="navbar-item" href="{{ url('/filmes/' . $m->slug) }}">{{ $m->name }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link dropdown-title">Séries</a>

                    <div class="navbar-dropdown">
                        @foreach($media as $m)
                            <a class="navbar-item" href="{{ url('/series/' . $m->slug) }}">{{ $m->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="navbar-end">
                @guest
                    <a class="navbar-item" href="{{ url('/login') }}">Login</a>
                    <a class="navbar-item" href="#">Registro</a>
                @else
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link dropdown-title">{{ Auth::user()->name }}</a>
                        <div class="navbar-dropdown">
                            <a class="navbar-item" href="#">Admin</a>
                            <a class="navbar-item" href="#">Logout</a>
                        </div>
                        </li>
                        @endguest
                    </div>
            </div>
        </div>
</nav>
