<?php

session_start();
require_once("../Conexao/conexao.php");
require_once("finance_functions.php");

// Buscar dados iniciais
$periodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : 30;
$receitaTotal = getReceitaTotal($pdo, $periodo);
$despesasTotal = getDespesasTotal($pdo, $periodo);
$lucroLiquido = $receitaTotal - $despesasTotal;
$pagamentosPendentes = getPagamentosPendentes($pdo);

// Buscar quantidade de OS com pagamentos pendentes
try {
    $query = "SELECT COUNT(DISTINCT id_os) as total 
              FROM pagamento 
              WHERE status != 'Concluído'";
    $stmt = $pdo->query($query);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $quantidadePendentes = $row['total'];
} catch (Exception $e) {
    $quantidadePendentes = 0;
}

// Buscar últimas ordens de serviço
$ultimasOrdens = getUltimasOrdens($pdo, 5);

// Buscar últimas ordens de serviço
try {
    $query = "SELECT os.id, c.nome as cliente, os.data_criacao, 
                        (SELECT COALESCE(SUM(valor), 0) 
                        FROM servicos_os s 
                        INNER JOIN equipamentos_os e ON s.id_equipamento = e.id 
                        WHERE e.id_os = os.id) as valor_total,
                        (SELECT CASE 
                            WHEN EXISTS (SELECT 1 FROM pagamento p WHERE p.id_os = os.id AND p.status != 'Concluído') 
                            THEN 'Pendente' ELSE 'Pago' END) as status 
                FROM ordens_servico os 
                LEFT JOIN cliente c ON os.id_cliente = c.id_cliente 
                ORDER BY os.data_criacao DESC 
                LIMIT 5";
    $stmt = $pdo->query($query);
    $ultimasOrdens = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $ultimasOrdens = [];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Financeiro - Sistema de Assistência Técnica</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <link rel="stylesheet" href="dashboard.css" />
    <!-- Links bootstrapt e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="cliente.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

    <!-- Link notfy -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <!-- Link das máscaras dos campos -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <style>
        .status.pago {
            background-color: #2ecc71;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            display: inline-block;
        }

        .status.pendente {
            background-color: #f39c12;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            display: inline-block;
        }

        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
        }

        .card-value {
            font-size: 24px;
            font-weight: bold;
            padding: 15px;
        }

        .card-footer {
            padding: 10px 15px;
            background-color: #f8f9fa;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .card-icon {
            font-size: 24px;
        }

        .receita {
            color: #2ecc71;
        }

        .despesa {
            color: #e74c3c;
        }

        .lucro {
            color: #3498db;
        }

        .pendente {
            color: #f39c12;
        }

        .charts-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <?php include("../Menu_lateral/menu.php"); ?>
    <div class="container">
        <div class="main-content">
            <div class="header">
                <h1 class="page-title">Dashboard Financeiro</h1>
                <div class="filter-options">
                    <select id="periodo">
                        <option value="7">Últimos 7 dias</option>
                        <option value="30" selected>Últimos 30 dias</option>
                        <option value="90">Últimos 3 meses</option>
                        <option value="180">Últimos 6 meses</option>
                        <option value="365">Último ano</option>
                    </select>
                    <input type="month" id="mesSelecionado">
                    <button onclick="carregarDados()" class="btn btn-primary" id="btn-carregar">
                        <span id="btn-text">Aplicar Filtros</span>
                        <span id="btn-loading" class="loading" style="display: none;"></span>
                    </button>
                </div>
            </div>

            <!-- Cards com métricas -->
            <div class="cards-row">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Receita Total</div>
                        <div class="card-icon receita"><i class="bi bi-cash-coin"></i></div>
                    </div>
                    <div class="card-value" id="receita-total">R$ 0,00</div>
                    <div class="card-footer" id="variacao-receita">Valor total recebido (pagamentos concluídos)</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Despesas</div>
                        <div class="card-icon despesa"><i class="bi bi-sort-down-alt"></i></div>
                    </div>
                    <div class="card-value" id="despesas-total">R$
                        <?php echo number_format($despesasTotal, 2, ',', '.'); ?></div>
                    <div class="card-footer" id="variacao-despesas">Custo das peças utilizadas</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Lucro Líquido</div>
                        <div class="card-icon lucro"><i class="bi bi-reception-4"></i></div>
                    </div>
                    <div class="card-value" id="lucro-liquido">R$
                        <?php echo number_format($lucroLiquido, 2, ',', '.'); ?></div>
                    <div class="card-footer" id="variacao-lucro">Receita - Despesas</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Pagamentos Pendentes</div>
                        <div class="card-icon pendente"><i class="bi bi-clock-history"></i></div>
                    </div>
                    <div class="card-value" id="pagamentos-pendentes">R$
                        <?php echo number_format($pagamentosPendentes, 2, ',', '.'); ?></div>
                    <div class="card-footer" id="quantidade-pendentes"><?php echo $quantidadePendentes; ?> ordens com
                        pagamento pendente</div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="charts-row">
                <div class="chart-container">
                    <h3 class="chart-title">Receita e Despesas por Mês</h3>
                    <canvas id="receitaDespesasChart"></canvas>
                </div>

                <div class="chart-container">
                    <h3 class="chart-title">Status de Pagamentos</h3>
                    <canvas id="statusPagamentosChart"></canvas>
                </div>
            </div>

            <!-- Tabela de ordens de serviço recentes -->
            <div class="table-container">
                <h3 class="chart-title">Últimas Ordens de Serviço</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nº OS</th>
                            <th>Cliente</th>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Status Pagamento</th>
                        </tr>
                    </thead>
                    <tbody id="tabela-os">
                        <?php if (!empty($ultimasOrdens)): ?>
                            <?php foreach ($ultimasOrdens as $ordem): ?>
                                <tr>
                                    <td>OS-<?php echo str_pad($ordem['id'], 5, '0', STR_PAD_LEFT); ?></td>
                                    <td><?php echo htmlspecialchars($ordem['cliente']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($ordem['data_criacao'])); ?></td>
                                    <td>R$ <?php echo number_format($ordem['valor_total'], 2, ',', '.'); ?></td>
                                    <td>
                                        <span class="status <?php echo strtolower($ordem['status']); ?>">
                                            <?php echo $ordem['status']; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">Nenhuma ordem de serviço encontrada</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Variáveis globais para os gráficos
        let receitaDespesasChart;
        let statusPagamentosChart;

        // Dados iniciais do PHP
        const dadosIniciais = {
            receitaTotal: <?php echo $receitaTotal; ?>,
            despesasTotal: <?php echo $despesasTotal; ?>,
            lucroLiquido: <?php echo $lucroLiquido; ?>,
            pagamentosPendentes: <?php echo $pagamentosPendentes; ?>,
            quantidadePendentes: <?php echo $quantidadePendentes; ?>,
            ultimasOrdens: <?php echo json_encode($ultimasOrdens); ?>
        };

        // Função para formatar valores monetários
        function formatarValor(valor) {
            return parseFloat(valor || 0).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Função para mostrar/ocultar loading
        function toggleLoading(show) {
            const btnText = document.getElementById('btn-text');
            const btnLoading = document.getElementById('btn-loading');
            const btn = document.getElementById('btn-carregar');

            if (show) {
                btnText.style.display = 'none';
                btnLoading.style.display = 'inline-block';
                btn.disabled = true;
            } else {
                btnText.style.display = 'inline-block';
                btnLoading.style.display = 'none';
                btn.disabled = false;
            }
        }

        // Função para carregar os dados do dashboard via AJAX
        function carregarDados() {
            toggleLoading(true);

            const periodo = document.getElementById('periodo').value;
            const mesSelecionado = document.getElementById('mesSelecionado').value;

            // Fazer requisição AJAX
            fetch('buscar_dados_dashboard.php?periodo=' + periodo + '&mes=' + mesSelecionado)
                .then(response => {
                    // Verificar se a resposta é JSON válido
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new TypeError('Resposta não é JSON válido');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.sucesso) {
                        // Atualizar cards com métricas
                        document.getElementById('receita-total').textContent = 'R$ ' + formatarValor(data.receitaTotal);
                        document.getElementById('despesas-total').textContent = 'R$ ' + formatarValor(data.despesasTotal);
                        document.getElementById('lucro-liquido').textContent = 'R$ ' + formatarValor(data.lucroLiquido);
                        document.getElementById('pagamentos-pendentes').textContent = 'R$ ' + formatarValor(data.pagamentosPendentes);
                        document.getElementById('quantidade-pendentes').textContent = data.quantidadePendentes + ' ordens com pagamento pendente';
                        document.getElementById('variacao-receita').textContent = 'Dados dos últimos ' + periodo + ' dias';

                        // Atualizar gráficos
                        atualizarGraficos(data.dadosGrafico, data.dadosStatus);

                        // Atualizar tabela de ordens de serviço
                        atualizarTabelaOS(data.ultimasOrdens);
                    } else {
                        console.error('Erro ao carregar dados:', data.erro);
                        alert('Erro ao carregar dados: ' + data.erro);
                    }
                    toggleLoading(false);
                })
                .catch(error => {
                    console.error('Erro na requisição:', error);
                    alert('Erro ao carregar dados. Verifique se o arquivo buscar_dados_dashboard.php existe e está funcionando corretamente.');
                    toggleLoading(false);

                    // Usar dados iniciais em caso de falha
                    usarDadosIniciais();
                });
        }

        // Função para usar dados iniciais em caso de falha na requisição
        function usarDadosIniciais() {
            const receita = parseFloat(dadosIniciais.receitaTotal || 0);
            const despesas = parseFloat(dadosIniciais.despesasTotal || 0);
            const lucro = parseFloat(dadosIniciais.lucroLiquido || 0);
            const pendentes = parseFloat(dadosIniciais.pagamentosPendentes || 0);
            const qtdPendentes = parseInt(dadosIniciais.quantidadePendentes || 0);

            document.getElementById('receita-total').textContent = 'R$ ' + formatarValor(receita);
            document.getElementById('despesas-total').textContent = 'R$ ' + formatarValor(despesas);
            document.getElementById('lucro-liquido').textContent = 'R$ ' + formatarValor(lucro);
            document.getElementById('pagamentos-pendentes').textContent = 'R$ ' + formatarValor(pendentes);
            document.getElementById('quantidade-pendentes').textContent = qtdPendentes + ' ordens com pagamento pendente';

            // Dados para gráficos (exemplo)
            const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'];
            const receitas = [receita * 0.7, receita * 0.8, receita * 0.9, receita, receita * 1.1, receita * 1.2];
            const despesasGraf = [despesas * 0.7, despesas * 0.8, despesas * 0.9, despesas, despesas * 1.1, despesas * 1.2];

            // Atualizar gráficos
            atualizarGraficoReceitaDespesas(meses, receitas, despesasGraf);

            // Gráfico de status
            const totalOrdens = Math.max(dadosIniciais.ultimasOrdens.length, 1);
            const pagosCount = totalOrdens - qtdPendentes;
            const percentualPagos = (pagosCount / totalOrdens) * 100;
            const percentualPendentes = (qtdPendentes / totalOrdens) * 100;

            atualizarGraficoStatusPagamentos([percentualPagos, percentualPendentes]);

            // Atualizar tabela
            atualizarTabelaOS(dadosIniciais.ultimasOrdens);
        }

        // Função para atualizar os gráficos com dados reais
        function atualizarGraficos(dadosGrafico, dadosStatus) {
            // Preparar dados para o gráfico de receita e despesas
            const meses = dadosGrafico.map(item => {
                const [ano, mes] = item.mes.split('-');
                return `${mes}/${ano}`;
            });

            const receitas = dadosGrafico.map(item => parseFloat(item.receita));
            const despesas = dadosGrafico.map(item => parseFloat(item.despesas));

            // Atualizar gráfico de receita e despesas
            atualizarGraficoReceitaDespesas(meses, receitas, despesas);

            // Atualizar gráfico de status de pagamentos
            const total = parseInt(dadosStatus.total) || 1;
            const percentualPagos = (parseInt(dadosStatus.concluidas) / total) * 100;
            const percentualPendentes = (parseInt(dadosStatus.pendentes) / total) * 100;

            atualizarGraficoStatusPagamentos([percentualPagos, percentualPendentes]);
        }

        // Função para atualizar o gráfico de receitas e despesas
        function atualizarGraficoReceitaDespesas(meses, receitas, despesas) {
            const ctx = document.getElementById('receitaDespesasChart').getContext('2d');

            // Destruir gráfico existente se houver
            if (receitaDespesasChart) {
                receitaDespesasChart.destroy();
            }

            // Criar novo gráfico
            receitaDespesasChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: meses,
                    datasets: [
                        {
                            label: 'Receita',
                            data: receitas,
                            backgroundColor: '#2ecc71',
                            borderColor: '#27ae60',
                            borderWidth: 1
                        },
                        {
                            label: 'Despesas',
                            data: despesas,
                            backgroundColor: '#e74c3c',
                            borderColor: '#c0392b',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'R$ ' + value.toLocaleString('pt-BR');
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return context.dataset.label + ': R$ ' + context.raw.toLocaleString('pt-BR');
                                }
                            }
                        }
                    }
                }
            });
        }

        // Função para atualizar o gráfico de status de pagamentos
        function atualizarGraficoStatusPagamentos(dados) {
            const ctx = document.getElementById('statusPagamentosChart').getContext('2d');

            // Destruir gráfico existente se houver
            if (statusPagamentosChart) {
                statusPagamentosChart.destroy();
            }

            // Criar novo gráfico
            statusPagamentosChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pagos', 'Pendentes'],
                    datasets: [{
                        data: dados,
                        backgroundColor: [
                            '#2ecc71',
                            '#f39c12'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return context.label + ': ' + context.raw.toFixed(1) + '%';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Função para atualizar a tabela de ordens de serviço
        function atualizarTabelaOS(dados) {
            const tabela = document.getElementById('tabela-os');
            tabela.innerHTML = '';

            if (!dados || dados.length === 0) {
                tabela.innerHTML = '<tr><td colspan="5" style="text-align: center;">Nenhuma ordem de serviço encontrada</td></tr>';
                return;
            }

            dados.forEach(item => {
                const tr = document.createElement('tr');

                // Formatar data
                const data = new Date(item.data_criacao);
                const dataFormatada = data.toLocaleDateString('pt-BR');

                // Formatar valor
                const valorFormatado = 'R$ ' + formatarValor(item.valor_total);

                tr.innerHTML = `
            <td>OS-${item.id.toString().padStart(5, '0')}</td>
            <td>${item.cliente}</td>
            <td>${dataFormatada}</td>
            <td>${valorFormatado}</td>
            <td><span class="status ${item.status.toLowerCase()}">${item.status.charAt(0).toUpperCase() + item.status.slice(1).toLowerCase()}</span></td>
        `;

                tabela.appendChild(tr);
            });
        }

        // Inicializar o dashboard quando a página carregar
        document.addEventListener('DOMContentLoaded', function () {
            // Definir mês atual como padrão
            const agora = new Date();
            const mesAtual = agora.toISOString().slice(0, 7);
            document.getElementById('mesSelecionado').value = mesAtual;

            // Carregar dados iniciais
            carregarDados();
        });
    </script>
</body>

</html>