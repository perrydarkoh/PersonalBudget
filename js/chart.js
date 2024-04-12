document.addEventListener('DOMContentLoaded', (event) => {
    const monthlyExpenses = JSON.parse(document.getElementById('monthlyExpensesData').textContent);
    const ctx = document.getElementById('expensesChart').getContext('2d');
    const labels = Object.keys(monthlyExpenses).map(month => `Month ${month}`);
    const data = Object.values(monthlyExpenses);

    const expensesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Monthly Expenses',
                data: data,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {}
    });
});
