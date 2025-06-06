<!DOCTYPE html>
<html lang="pl">
    @include('shared.head', ['pageTitle' => 'Błąd'])
    <body>
        @include('shared.navigation')

        <main style="padding: 2rem 0;">
            @yield('content')
        </main>

        @include('shared.footer')
    </body>
</html>
