<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-content">
            <a href="/" class="navbar-brand">MarketPlace</a>
            <div class="navbar-menu">
                @if (Auth::check())
                    <a class="nav-link" href="{{ route('logout') }}">{{ Auth::user()->first_name }}, wyloguj się... </a>
                @else
                    <a class="nav-link" href="{{ route('login') }}">Zaloguj się</a>
                @endif
                <a href="#" class="btn-primary">Create Offer</a>
            </div>
        </div>
    </div>
</nav>
