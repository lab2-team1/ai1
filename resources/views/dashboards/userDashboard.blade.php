<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'MarketPlace - Buy and Sell with Ease'])
    <body>
        <!-- Navigation -->
        @include('shared.navigation')

        <div class="user-panel">
        <!-- Sidebar -->    
        @include('shared.userSidebar')
        <section class="user-content">
        <h1>USER PANEL</h1>
        <form>
            <div class="user-field">
                <label for="field1">{{ Auth::user()->first_name }}</label>
            </div>
            <div class="user-field">
                <label for="field2">{{ Auth::user()->last_name }}</label>
            </div>
            <div class="user-field">
                <label for="field3">{{ Auth::user()->email }}</label>
            </div>
            <div class="user-field">
                <label for="field3">{{ Auth::user()->phone }}</label>
            </div>
            </form>
        </section>
        </div>

        <!-- Footer -->
        @include('shared.footer')

    </body>
</html>
