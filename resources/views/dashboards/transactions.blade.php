<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'Transaction History'])
    <body>
        @include('shared.navigation')
        <div class="user-panel">
            @include('shared.userSidebar')
            <section class="user-content">
                <h1>Transaction History</h1>
                <h2>Bought</h2>
                @if($transactionsBought->isEmpty())
                    <p>No purchases found.</p>
                @else
                    <table class="table admin-table">
                        <thead>
                            <tr>
                                <th>Listing</th>
                                <th>Seller</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactionsBought as $transaction)
                            <tr>
                                <td>
                                    @if($transaction->listing)
                                        <a href="{{ route('listings.show', $transaction->listing->id) }}">{{ $transaction->listing->title }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $transaction->seller ? $transaction->seller->first_name . ' ' . $transaction->seller->last_name : '-' }}</td>
                                <td>{{ number_format($transaction->amount, 2) }} PLN</td>
                                <td>{{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('d.m.Y H:i') : '-' }}</td>
                                <td>{{ ucfirst($transaction->payment_status) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <h2>Sold</h2>
                @if($transactionsSold->isEmpty())
                    <p>No sales found.</p>
                @else
                    <table class="table admin-table">
                        <thead>
                            <tr>
                                <th>Listing</th>
                                <th>Buyer</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactionsSold as $transaction)
                            <tr>
                                <td>
                                    @if($transaction->listing)
                                        <a href="{{ route('listings.show', $transaction->listing->id) }}">{{ $transaction->listing->title }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $transaction->buyer ? $transaction->buyer->first_name . ' ' . $transaction->buyer->last_name : '-' }}</td>
                                <td>{{ number_format($transaction->amount, 2) }} PLN</td>
                                <td>{{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('d.m.Y H:i') : '-' }}</td>
                                <td>{{ ucfirst($transaction->payment_status) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </section>
        </div>
        @include('shared.footer')
    </body>
</html>
