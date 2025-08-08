const ctx = document.getElementById('graficoFluxo').getContext('2d');
const graficoFluxo = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ,
        datasets: [{
            label: 'R$',
            data: ,
            fill: false,
            borderColor: 'rgba(75, 192, 192, 1)',
            tension: 0.2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});