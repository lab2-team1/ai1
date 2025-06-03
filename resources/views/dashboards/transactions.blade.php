<!-- filepath: resources/views/dashboards/transactions.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('shared.head', ['pageTitle' => 'Transaction History'])

<body>
    @include('shared.navigation')
    <div class="user-panel">
        @include('shared.userSidebar')
        <section class="user-content">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <h1>Transaction History</h1>
            <h2>Bought</h2>
            @if ($transactionsBought->isEmpty())
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
                            <th>Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactionsBought as $transaction)
                            <tr>
                                <td>
                                    @if ($transaction->listing)
                                        <a
                                            href="{{ route('listings.show', $transaction->listing->id) }}">{{ $transaction->listing->title }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $transaction->seller ? $transaction->seller->first_name . ' ' . $transaction->seller->last_name : '-' }}
                                </td>
                                <td>{{ number_format($transaction->amount, 2) }} PLN</td>
                                <td>{{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('d.m.Y H:i') : '-' }}
                                </td>
                                <td>{{ ucfirst($transaction->payment_status) }}
                                    @if ($transaction->payment_status === 'pending')
                                        <form method="POST" action="{{ route('transactions.confirm', $transaction->id) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm" style="margin-left: 8px; padding: 2px 10px; font-size: 0.85em;">Confirm receipt</button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    @if (in_array($transaction->payment_status, ['confirmed', 'canceled']))
                                        @php
                                            $alreadyRated = \App\Models\UserRating::where(
                                                'transaction_id',
                                                $transaction->id,
                                            )
                                                ->where('rated_by_user_id', auth()->id())
                                                ->exists();
                                        @endphp
                                        @if ($alreadyRated)
                                            <span title="Ocena już wystawiona"
                                                style="color: #aaa; font-size: 1.3em;">&#9733;</span>
                                        @else
                                            <a href="{{ route('userRatings.create', ['transaction_id' => $transaction->id]) }}"
                                                title="Wystaw ocenę" style="color: #f5b301; font-size: 1.3em;">
                                                &#9733;
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <h2>Sold</h2>
            @if ($transactionsSold->isEmpty())
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
                            <th>Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactionsSold as $transaction)
                            <tr>
                                <td>
                                    @if ($transaction->listing)
                                        <a
                                            href="{{ route('listings.show', $transaction->listing->id) }}">{{ $transaction->listing->title }}</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $transaction->buyer ? $transaction->buyer->first_name . ' ' . $transaction->buyer->last_name : '-' }}
                                </td>
                                <td>{{ number_format($transaction->amount, 2) }} PLN</td>
                                <td>{{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('d.m.Y H:i') : '-' }}
                                </td>
                                <td>{{ ucfirst($transaction->payment_status) }}</td>
                                <td>
                                    @if (in_array($transaction->payment_status, ['confirmed', 'canceled']))
                                        <a href="{{ route('userRatings.create', ['transaction_id' => $transaction->id]) }}"
                                            title="Wystaw ocenę" style="color: #f5b301; font-size: 1.3em;">
                                            &#9733;
                                        </a>
                                    @endif
                                </td>
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
