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

            <div id="transactionsTab" class="tab-content" style="display: block;">
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
                                            <a href="{{ route('listings.show', $transaction->listing->id) }}">{{ $transaction->listing->title }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $transaction->seller ? $transaction->seller->first_name . ' ' . $transaction->seller->last_name : '-' }}</td>
                                    <td>{{ number_format($transaction->amount, 2) }} PLN</td>
                                    <td>{{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('d.m.Y H:i') : '-' }}</td>
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
                                                $alreadyRated = \App\Models\UserRating::where('transaction_id', $transaction->id)->where('rated_by_user_id', auth()->id())->exists();
                                            @endphp
                                            @if ($alreadyRated)
                                                <span title="Ocena już wystawiona" style="color: #aaa; font-size: 1.3em;">&#9733;</span>
                                            @else
                                                <a href="{{ route('userRatings.create', ['transaction_id' => $transaction->id]) }}" title="Wystaw ocenę" style="color: #f5b301; font-size: 1.3em;">&#9733;</a>
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
                        </thead>
                        <tbody>
                            @foreach ($transactionsSold as $transaction)
                                <tr>
                                    <td>
                                        @if ($transaction->listing)
                                            <a href="{{ route('listings.show', $transaction->listing->id) }}">{{ $transaction->listing->title }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $transaction->buyer ? $transaction->buyer->first_name . ' ' . $transaction->buyer->last_name : '-' }}</td>
                                    <td>{{ number_format($transaction->amount, 2) }} PLN</td>
                                    <td>{{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('d.m.Y H:i') : '-' }}</td>
                                    <td>{{ ucfirst($transaction->payment_status) }}</td>
                                    <td>
                                        @if (in_array($transaction->payment_status, ['confirmed', 'canceled']))
                                            <a href="{{ route('userRatings.create', ['transaction_id' => $transaction->id]) }}" title="Wystaw ocenę" style="color: #f5b301; font-size: 1.3em;">&#9733;</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div id="statsTab" class="tab-content" style="display: none;">
                <h1>Statystyki transakcji</h1>
                <div class="transaction-stats" style="margin-bottom: 2rem;">
                    <ul style="list-style: none; padding: 0; display: flex; gap: 2rem; flex-wrap: wrap;">
                        <li><strong>Liczba kupionych:</strong> {{ $transactionsBought->count() }}</li>
                        <li><strong>Liczba sprzedanych:</strong> {{ $transactionsSold->count() }}</li>
                        <li><strong>Suma wydatków:</strong> {{ number_format($transactionsBought->sum('amount'), 2) }} PLN</li>
                        <li><strong>Suma zarobków:</strong> {{ number_format($transactionsSold->sum('amount'), 2) }} PLN</li>
                        <li><strong>Średnia wartość zakupu:</strong> {{ $transactionsBought->count() ? number_format($transactionsBought->avg('amount'), 2) : '0.00' }} PLN</li>
                        <li><strong>Średnia wartość sprzedaży:</strong> {{ $transactionsSold->count() ? number_format($transactionsSold->avg('amount'), 2) : '0.00' }} PLN</li>
                        @php
                            $allTransactions = $transactionsBought->merge($transactionsSold);
                            $monthlyStats = $allTransactions->groupBy(function($item) { return \Carbon\Carbon::parse($item->transaction_date)->format('Y-m'); });
                            $monthlyLabels = $monthlyStats->keys()->sort()->values();
                            $monthlyBought = $monthlyLabels->map(fn($month) => $transactionsBought->where('transaction_date', '>=', $month.'-01')->where('transaction_date', '<=', $month.'-31')->count());
                            $monthlySold = $monthlyLabels->map(fn($month) => $transactionsSold->where('transaction_date', '>=', $month.'-01')->where('transaction_date', '<=', $month.'-31')->count());
                            $monthlyBoughtSum = $monthlyLabels->map(fn($month) => $transactionsBought->where('transaction_date', '>=', $month.'-01')->where('transaction_date', '<=', $month.'-31')->sum('amount'));
                            $monthlySoldSum = $monthlyLabels->map(fn($month) => $transactionsSold->where('transaction_date', '>=', $month.'-01')->where('transaction_date', '<=', $month.'-31')->sum('amount'));
                            $popularCategory = $allTransactions->filter(fn($t) => $t->listing && $t->listing->category)->groupBy(fn($t) => $t->listing->category->name)->sortByDesc(fn($g) => $g->count())->keys()->first();
                        @endphp
                        <li><strong>Najpopularniejsza kategoria:</strong> {{ $popularCategory ?? '-' }}</li>
                    </ul>
                    <div style="max-width: 700px; margin-top: 2rem;">
                        <canvas id="transactionsCountChart"></canvas>
                    </div>
                    <div style="max-width: 700px; margin-top: 2rem;">
                        <canvas id="transactionsSumChart"></canvas>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('shared.footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div id="transactions-data" style="display:none"
        data-labels='@json($monthlyLabels ?? [])'
        data-bought='@json($monthlyBought ?? [])'
        data-sold='@json($monthlySold ?? [])'
        data-boughtsum='@json($monthlyBoughtSum ?? [])'
        data-soldsum='@json($monthlySoldSum ?? [])'>
    </div>
    <script src="/js/transactionStats.js"></script>
</body>

</html>
