<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', ['pageTitle' => 'Rejestracja'])

<body>
    @include('shared.navigation')

    <div class="main-content">
        <div class="container">
            <div class="register-form-container">
                <h1 class="register-title">Rejestracja</h1>
                <form method="POST" action="{{ route('register.store') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="first_name" class="form-label">Imię</label>
                        <input id="first_name" name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" maxlength="50">
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="form-label">Nazwisko</label>
                        <input id="last_name" name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" maxlength="50">
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" maxlength="100">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Hasło</label>
                        <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" minlength="8" maxlength="255">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Numer telefonu</label>
                        <input id="phone" name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="xxx-xxx-xxx">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Zarejestruj się</button>
                    </div>

                    <div class="form-group text-center mt-3">
                        <p>Masz już konto? <a href="{{ route('login') }}">Zaloguj się</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('shared.footer')

</body>

</html>
