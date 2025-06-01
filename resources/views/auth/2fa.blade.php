<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('shared.head', ['pageTitle' => 'MarketPlace - Uwierzytelnianie dwuskładnikowe (2FA)'])
<body>
    @include('shared.navigation')

    <div class="user-panel">
        @auth
        @include('shared.userSidebar')
        @endauth
        <section class="user-content">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('2fa:user:id'))
                <div class="container" style="max-width: 400px; margin: 0 auto;">
                    <h2 class="mt-4 mb-4 text-center">2FA Login Verification</h2>
                    <form method="POST" action="{{ route('2fa.verify.post') }}" class="card p-4 shadow-sm" style="padding: 25px;margin-top:30px;">
                        @csrf
                        <div class="mb-3 p-3">
                            <label for="otp_code" class="form-label">Code from Authenticator App</label>
                            <input type="text" name="otp_code" id="otp_code" class="form-control" required autofocus style="margin: 25px 0;">
                            @error('otp_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Verify</button>
                    </form>
                </div>
            @elseif(Auth::check() && Auth::user()->two_factor_enabled)
                <div class="alert alert-success">
                    2FA is enabled.
                </div>
                <form action="{{ route('user.2fa.disable') }}" method="POST" class="mt-3">
                    @csrf
                    <div class="mb-3">
                        <label for="password">Enter your password to disable 2FA:</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-danger">Disable 2FA</button>
                </form>
            @elseif(Auth::check() && !Auth::user()->two_factor_enabled)
                <div class="mb-3">
                    <p>Scan this QR code with your authenticator app or enter the secret manually:</p>
                    <img src="{{ $qrCodeUrl }}" alt="2FA setup QR code">
                    <p>Secret: <code>{{ $secretKey }}</code></p>
                </div>
                <form action="{{ route('user.2fa.enable') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="code">Enter the code from your app:</label>
                        <input type="text" name="code" class="form-control" required>
                        @error('code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Enable 2FA</button>
                </form>
            @endif
        </section>
    </div>

    @include('shared.footer')
</body>
</html>
