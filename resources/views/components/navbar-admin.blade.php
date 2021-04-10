<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
    <div class="container is-max-widescreen">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ url('/admin') }}">{{ config('app.name', 'Laravel') }}</a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false"
               data-target="navbarAdmin">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarAdmin" class="navbar-menu">
            <div class="navbar-start">
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link dropdown-title">Filmes</a>

                    <div class="navbar-dropdown">
                        @foreach($media as $m)
                            <a class="navbar-item" href="{{ url('/admin/filmes/' . $m->slug) }}">{{ $m->name }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link dropdown-title">Séries</a>

                    <div class="navbar-dropdown">
                        @foreach($media as $m)
                            <a class="navbar-item" href="{{ url('/admin/series/' . $m->slug) }}">{{ $m->name }}</a>
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
                            <a class="navbar-item" href="{{ url('/') }}">Home</a>
                            <a class="navbar-item" href="{{ url('/logout') }}">Logout</a>
                        </div>
                        </li>
                        @endguest
                    </div>
            </div>
        </div>
    </div>
</nav>
