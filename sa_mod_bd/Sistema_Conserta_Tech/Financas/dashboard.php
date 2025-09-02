<?php
include '../Conexao/conexao.php';

// Receitas por mês
$sqlAndamento ="SELECT count(id_os) FROM os WHERE status=1";
$sqlConcluido ="SELECT count(id_os) FROM os WHERE status=2";
$sqlAtrasado ="SELECT count(id_os) FROM os WHERE status=3";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Gráfico de Pizza</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h1>Gastos por Categoria</h1>
<canvas id="pizzaChart" width="400" height="400"></canvas>

<script>
const ctx = document.getElementById('pizzaChart').getContext('2d');

const pizzaChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode(20); ?>,
        datasets: [{
            data: <?php echo json_encode(10); ?>,
            backgroundColor: [
                'rgba(75, 192, 192, 0.6)',
                'rgba(255, 99, 132, 0.6)',
                'rgba(255, 205, 86, 0.6)',
                'rgba(54, 162, 235, 0.6)'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>

</body>
</html>
