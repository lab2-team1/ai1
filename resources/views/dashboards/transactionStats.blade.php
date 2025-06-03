<!DOCTYPE html>
<html lang="en">
@include('shared.head', ['pageTitle' => 'Transaction Stats'])
<body>
@include('shared.navigation')
<div class="user-panel">
    @include('shared.userSidebar')
    <section class="user-content">
        <h1>Transaction Statistics</h1>
        <div class="transaction-stats" style="margin-bottom: 2rem;">
            <ul style="list-style: none; padding: 0; display: flex; gap: 2rem; flex-wrap: wrap;">
                <li><strong>Bought count:</strong> {{ $transactionsBought->count() }}</li>
                <li><strong>Sold count:</strong> {{ $transactionsSold->count() }}</li>
                <li><strong>Total spent:</strong> {{ number_format($transactionsBought->sum('amount'), 2) }} PLN</li>
                <li><strong>Total earned:</strong> {{ number_format($transactionsSold->sum('amount'), 2) }} PLN</li>
                <li><strong>Average purchase value:</strong> {{ $transactionsBought->count() ? number_format($transactionsBought->avg('amount'), 2) : '0.00' }} PLN</li>
                <li><strong>Average sale value:</strong> {{ $transactionsSold->count() ? number_format($transactionsSold->avg('amount'), 2) : '0.00' }} PLN</li>
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
                <li><strong>Most popular category:</strong> {{ $popularCategory ?? '-' }}</li>
            </ul>
            <div style="max-width: 700px; margin-top: 2rem;">
                <canvas id="transactionsCountChart"></canvas>
            </div>
            <div style="max-width: 700px; margin-top: 2rem;">
                <canvas id="transactionsSumChart"></canvas>
            </div>
        </div>
    </section>
</div>
@include('shared.footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data for charts from PHP
    const monthlyLabels = @json($monthlyLabels ?? []);
    const monthlyBought = @json($monthlyBought ?? []);
    const monthlySold = @json($monthlySold ?? []);
    const monthlyBoughtSum = @json($monthlyBoughtSum ?? []);
    const monthlySoldSum = @json($monthlySoldSum ?? []);
    document.addEventListener('DOMContentLoaded', function() {
        // Transaction count chart
        const ctx1 = document.getElementById('transactionsCountChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [
                    {
                        label: 'Bought',
                        data: monthlyBought,
                        backgroundColor: '#60a5fa',
                    },
                    {
                        label: 'Sold',
                        data: monthlySold,
                        backgroundColor: '#fbbf24',
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Monthly transaction count' }
                },
                scales: { y: { beginAtZero: true } }
            }
        });
        // Transaction value sum chart
        const ctx2 = document.getElementById('transactionsSumChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [
                    {
                        label: 'Total spent (bought)',
                        data: monthlyBoughtSum,
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37,99,235,0.1)',
                        fill: true,
                    },
                    {
                        label: 'Total earned (sold)',
                        data: monthlySoldSum,
                        borderColor: '#f59e42',
                        backgroundColor: 'rgba(245,158,66,0.1)',
                        fill: true,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Monthly transaction value (PLN)' }
                },
                scales: { y: { beginAtZero: true } }
            }
        });
    });
</script>
</body>
</html>
