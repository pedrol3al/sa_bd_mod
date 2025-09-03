<?php
    session_start();
    require_once("../Conexao/conexao.php");

    // Funções para buscar dados do banco
    function getReceitaTotal($conn, $periodo = 30) {
        $dataInicio = date('Y-m-d', strtotime("-$periodo days"));
        
        $query = "SELECT SUM(valor_total) as total 
                FROM pagamento 
                WHERE status = 'Pago' 
                AND data_pagamento >= '$dataInicio'";
        
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'] ? $row['total'] : 0;
    }

    function getDespesasTotal($conn, $periodo = 30) {
        $dataInicio = date('Y-m-d', strtotime("-$periodo days"));
        
        $query = "SELECT SUM(op.quantidade * e.valor_unitario) as total 
                FROM os_produto op 
                JOIN estoque e ON op.id_produto = e.id_produto 
                JOIN ordens_servico os ON op.id_os = os.id 
                JOIN pagamento p ON os.id = p.id_os 
                WHERE p.status = 'Pago' 
                AND p.data_pagamento >= '$dataInicio'";
        
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'] ? $row['total'] : 0;
    }

    function getPagamentosPendentes($conn) {
        $query = "SELECT SUM(valor_total) as total 
                FROM pagamento 
                WHERE status = 'Pendente'";
        
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'] ? $row['total'] : 0;
    }

    function getQuantidadePendentes($conn) {
        $query = "SELECT COUNT(*) as total 
                FROM pagamento 
                WHERE status = 'Pendente'";
        
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    function getUltimasOrdensServico($conn, $limit = 5) {
        $query = "SELECT os.id, c.nome as cliente, os.data_criacao, p.valor_total, p.status 
                FROM ordens_servico os 
                JOIN cliente c ON os.id_cliente = c.id_cliente 
                JOIN pagamento p ON os.id = p.id_os 
                ORDER BY os.data_criacao DESC 
                LIMIT $limit";
        
        $result = $conn->query($query);
        $ordens = [];
        
        while ($row = $result->fetch_assoc()) {
            $ordens[] = $row;
        }
        
        return $ordens;
    }

    function getReceitaMensal($conn, $meses = 6) {
        $query = "SELECT 
                    DATE_FORMAT(data_pagamento, '%Y-%m') as mes,
                    SUM(valor_total) as total
                FROM pagamento 
                WHERE status = 'Pago' 
                AND data_pagamento >= DATE_SUB(NOW(), INTERVAL $meses MONTH)
                GROUP BY DATE_FORMAT(data_pagamento, '%Y-%m')
                ORDER BY mes";
        
        $result = $conn->query($query);
        $dados = [];
        
        while ($row = $result->fetch_assoc()) {
            $dados[$row['mes']] = $row['total'];
        }
        
        return $dados;
    }

    function getStatusPagamentos($conn) {
        $query = "SELECT 
                    status,
                    COUNT(*) as quantidade,
                    SUM(valor_total) as valor_total
                FROM pagamento 
                GROUP BY status";
        
        $result = $conn->query($query);
        $dados = ['Pago' => 0, 'Pendente' => 0];
        
        while ($row = $result->fetch_assoc()) {
            $dados[$row['status']] = $row['quantidade'];
        }
        
        return $dados;
    }

    // Buscar dados iniciais
    $receitaTotal = getReceitaTotal($conn);
    $despesasTotal = getDespesasTotal($conn);
    $lucroLiquido = $receitaTotal - $despesasTotal;
    $pagamentosPendentes = getPagamentosPendentes($conn);
    $quantidadePendentes = getQuantidadePendentes($conn);
    $ultimasOrdens = getUltimasOrdensServico($conn);
    $receitaMensal = getReceitaMensal($conn);
    $statusPagamentos = getStatusPagamentos($conn);
    ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Financeiro - Sistema de Assistência Técnica</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <link rel="stylesheet" href="dashboard.css"/>
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
</head>
<body>
    <?php
            include("../Menu_lateral/menu.php"); 
        ?>
    <div class="container">
        <!-- Sidebar -->
        

        <!-- conteudo -->
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
                    <button onclick="carregarDados()">Aplicar Filtros</button>
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
                    <div class="card-footer" id="variacao-receita">+0% em relação ao período anterior</div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Despesas</div>
                        <div class="card-icon despesa"><i class="bi bi-sort-down-alt"></i></div>
                    </div>
                    <div class="card-value" id="despesas-total">R$ 0,00</div>
                    <div class="card-footer" id="variacao-despesas">+0% em relação ao período anterior</div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Lucro Líquido</div>
                        <div class="card-icon lucro"><i class="bi bi-reception-4"></i></div>
                    </div>
                    <div class="card-value" id="lucro-liquido">R$ 0,00</div>
                    <div class="card-footer" id="variacao-lucro">+0% em relação ao período anterior</div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Pagamentos Pendentes</div>
                        <div class="card-icon pendente"><i class="bi bi-clock-history"></i></div>
                    </div>
                    <div class="card-value" id="pagamentos-pendentes">R$ 0,00</div>
                    <div class="card-footer" id="quantidade-pendentes">0 ordens com pagamento pendente</div>
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
                        <tr>
                            <td colspan="5" style="text-align: center;">Carregando dados...</td>
                        </tr>
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
        return parseFloat(valor).toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Função para carregar os dados do dashboard
    function carregarDados() {
        // Usar dados iniciais do PHP
        document.getElementById('receita-total').textContent = 'R$ ' + formatarValor(dadosIniciais.receitaTotal);
        document.getElementById('despesas-total').textContent = 'R$ ' + formatarValor(dadosIniciais.despesasTotal);
        document.getElementById('lucro-liquido').textContent = 'R$ ' + formatarValor(dadosIniciais.lucroLiquido);
        document.getElementById('pagamentos-pendentes').textContent = 'R$ ' + formatarValor(dadosIniciais.pagamentosPendentes);
        
        document.getElementById('quantidade-pendentes').textContent = dadosIniciais.quantidadePendentes + ' ordens com pagamento pendente';
        
        // Simular dados para gráficos (você pode adaptar depois)
        const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'];
        const receitas = [dadosIniciais.receitaTotal * 0.8, dadosIniciais.receitaTotal * 0.9, dadosIniciais.receitaTotal, dadosIniciais.receitaTotal * 1.1, dadosIniciais.receitaTotal * 1.2, dadosIniciais.receitaTotal * 1.3];
        const despesas = [dadosIniciais.despesasTotal * 0.8, dadosIniciais.despesasTotal * 0.9, dadosIniciais.despesasTotal, dadosIniciais.despesasTotal * 1.1, dadosIniciais.despesasTotal * 1.2, dadosIniciais.despesasTotal * 1.3];
        
        // Atualizar gráficos
        atualizarGraficoReceitaDespesas(meses, receitas, despesas);
        
        // Gráfico de status (simplificado)
        const totalPagamentos = dadosIniciais.quantidadePendentes + (dadosIniciais.ultimasOrdens.length - dadosIniciais.quantidadePendentes);
        const percentualPagos = totalPagamentos > 0 ? ((dadosIniciais.ultimasOrdens.length - dadosIniciais.quantidadePendentes) / totalPagamentos) * 100 : 0;
        const percentualPendentes = totalPagamentos > 0 ? (dadosIniciais.quantidadePendentes / totalPagamentos) * 100 : 0;
        
        atualizarGraficoStatusPagamentos([percentualPagos, percentualPendentes]);
        
        // Atualizar tabela
        atualizarTabelaOS(dadosIniciais.ultimasOrdens);
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
                            callback: function(value) {
                                return 'R$ ' + value.toLocaleString('pt-BR');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
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
                            label: function(context) {
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
        
        if (dados.length === 0) {
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
    document.addEventListener('DOMContentLoaded', function() {
        // Carregar dados iniciais
        carregarDados();
    });
</script>
</body>
</html>