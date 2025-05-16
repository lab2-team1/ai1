<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('shared.head', ['pageTitle' => 'Log in'])

<body>
    @include('shared.navigation')

    <div class="main-content">
        <div class="container">
            <div class="login-form-container">
                <h1 class="login-title">Log in!</h1>
                <form method="POST" action="{{ route('login.authenticate') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="text" class="form-control @if ($errors->first('email')) is-invalid @endif" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">Please enter a valid email address!</div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">Please enter the correct password!</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Log in</button>
                    </div>
                </form>
                <div class="form-group text-center mt-3">
                        <p>Don't have an account yet? <a href="{{ route('register') }}">Register</a></p>
                    </div>
            </div>
        </div>
    </div>

    @include('shared.footer')
</body>

</html>
