<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'Purchase Confirmation'])
    <body>
        @include('shared.navigation')
        <main class="main-content">
            <div class="container">
                <div class="listing-details">
                    <div class="detail-group">
                        <h2>Thank you for your purchase!</h2>
                        <p class="listing-description">You have successfully purchased: <strong>{{ $transaction->listing->title }}</strong></p>
                        <p class="listing-description">Amount paid: <strong>{{ number_format($transaction->amount, 2) }} PLN</strong></p>
                        <p class="listing-description">Selected payment method: <strong>{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</strong></p>
                        <div class="button-container">
                            <a href="/" class="btn-primary btn-homepage">Go to homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include('shared.footer')
    </body>
</html>
