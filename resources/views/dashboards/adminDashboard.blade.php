<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'MarketPlace - Buy and Sell with Ease'])
    <body>
        <!-- Navigation -->
        @include('shared.navigation')

        <div class="admin-panel">
        @include('shared.adminSidebar')
        <section class="admin-content">
            <h1>ADMIN PANEL</h1>
            
        </section>
        </div>

        <!-- footer -->
        @include('shared.footer')

    </body>
</html>
