<nav class="user-sidebar">
    <ul>
        <li><a href="{{ route('user.dashboard') }}">Manage personal data</a></li>
        <li><a href="{{ route('user.listings.index') }}">Listings</a></li>
        <li><a href="{{ route('user.transactions') }}">Transaction History</a></li>
        <li><a href="{{ route('user.transactionStats') }}">Transaction Stats</a></li>
        <li><a href="{{ route('user.2fa') }}">2FA</a></li>
    </ul>
</nav>
