<nav class="navbar is-info navbar-frontend" role="navigation" aria-label="main navigation">
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
                <a class="navbar-item">Home</a>
                <a class="navbar-item">Documentation</a>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link dropdown-title">Filmes</a>

                    <div class="navbar-dropdown">
                        @foreach($media as $m)
                        <a class="navbar-item" href="{{ url('/filmes/' . $m->slug) }}">{{ $m->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="navbar-end">
                <a class="navbar-item">Register</a>
                <a class="navbar-item">Login</a>
            </div>
        </div>
    </div>
</nav>
