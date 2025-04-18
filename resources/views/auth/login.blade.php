<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', ['pageTitle' => 'Zaloguj się'])

<body>
    @include('shared.navigation')

    <div class="main-content">
        <div class="container">
            <div class="login-form-container">
                @include('shared.session-error')
                @include('shared.validation-error')

                <h1 class="login-title">Zaloguj się</h1>

                <form method="POST" action="{{ route('login.authenticate') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="text" class="form-control @if ($errors->first('email')) is-invalid @endif" value="{{ old('email') }}">
                        <div class="invalid-feedback">Nieprawidłowy email!</div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Hasło</label>
                        <input id="password" name="password" type="password" class="form-control @if ($errors->first('password')) is-invalid @endif">
                        <div class="invalid-feedback">Nieprawidłowe hasło!</div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Zaloguj się</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('shared.footer')
</body>

</html>

