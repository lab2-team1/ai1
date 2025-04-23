<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'Admin Dashboard'])
    <body>
        <!-- Navigation -->
        @include('shared.navigation')

        <div class="admin-panel">
            @include('shared.adminSidebar')
            <section class="admin-content">
                @yield('admin-content')
            </section>
        </div>

        <!-- Footer -->
        @include('shared.footer')
    </body>
</html>
