<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'Choose Payment Method'])
    <body>
        @include('shared.navigation')

        <main class="main-content">
            <div class="container">
                @if(session('success'))
                    <div id="payment-success-modal" class="modal" style="display: block;">
                        <div class="modal-content">
                            <h2>Success!</h2>
                            <p>{{ session('success') }}</p>
                            <button id="go-home-btn" class="btn-primary">Go to homepage</button>
                        </div>
                    </div>
                @endif
                <div class="listing-details">
                    <div class="detail-group">
                        <h2>Choose Payment Method</h2>
                        <p class="listing-description">For listing: <strong>{{ $transaction->listing->title }}</strong></p>
                        <p class="listing-description">Amount to pay: <strong>{{ number_format($transaction->amount, 2) }} PLN</strong></p>
                    </div>
                    <form method="POST" action="{{ route('payment.process', ['transaction' => $transaction->id]) }}">
                        @csrf
                        <div class="form-group">
                            <label><input type="radio" name="payment_method" value="blik"> BLIK</label><br>
                            <label><input type="radio" name="payment_method" value="bank_transfer"> Bank transfer</label><br>
                            <label><input type="radio" name="payment_method" value="on_delivery" checked> Cash on delivery</label>
                        </div>
                        <button type="submit" class="btn-primary">Pay</button>
                    </form>
                </div>
            </div>
        </main>

        @include('shared.footer')
        @vite('resources/js/payment-success.js')
    </body>
</html>
