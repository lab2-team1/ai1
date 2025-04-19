<nav class="navbar">
    <div class="navbar-container">
        <div class="navbar-content">
            <a href="/" class="navbar-brand">MarketPlace</a>
            <div class="navbar-menu">
                <div class="user-dropdown">
                    @if (Auth::check())
                        <div class="dropdown-wrapper user-info">
                            <span>{{ Auth::user()->first_name }}</span>
                            <i class="fa-solid fa-user user-icon"></i>
                            <div class="dropdown-content">
                                <a href="">Panel użytkownika</a>
                                <a href="{{ route('logout') }}">Wyloguj się</a>
                            </div>
                        </div>
                    @else
                        <div style="white-space: nowrap !important;">
                            <a href="{{ route('login') }}">
                                Zaloguj się!
                            </a>
                        </div>
                    @endif
                </div>
                <a href="#" class="btn-primary">Create Offer</a>
            </div>
        </div>
    </div>
</nav>
