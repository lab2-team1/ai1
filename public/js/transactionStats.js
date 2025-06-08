// Kod odpowiedzialny za wykresy transakcji
// Wymaga Chart.js (np. przez CDN w widoku lub import w bundlerze)

// Chart rendering logic
// Pobierz dane z atrybutów data- na elemencie #transactions-data
document.addEventListener('DOMContentLoaded', function() {
    const dataElem = document.getElementById('transactions-data');
    if (!dataElem) return;
    const monthlyLabels = JSON.parse(dataElem.dataset.labels || '[]');
    const monthlyBought = JSON.parse(dataElem.dataset.bought || '[]');
    const monthlySold = JSON.parse(dataElem.dataset.sold || '[]');
    const monthlyBoughtSum = JSON.parse(dataElem.dataset.boughtsum || '[]');
    const monthlySoldSum = JSON.parse(dataElem.dataset.soldsum || '[]');

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
                title: { display: true, text: 'Number of transactions per month' }
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
                title: { display: true, text: 'Total transaction value per month (PLN)' }
            },
            scales: { y: { beginAtZero: true } }
        }
    });
});
