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
                                <a href="{{ route('userDashboard') }}">User Panel</a>
                                @can('is-admin') 
                                <a href="{{ route('adminDashboard') }}">Admin Panel</a>
                                @endcan 
                                <a href="{{ route('logout') }}">Log out!</a>
                            </div>
                        </div>
                    @else
                        <div style="white-space: nowrap !important;">
                            <a href="{{ route('login') }}">
                                Log in!
                            </a>
                        </div>
                    @endif
                </div>
                <a href="{{ Auth::check() ? '#' : route('login') }}" class="btn-primary">Create Offer</a>
            </div>
        </div>
    </div>
</nav>
