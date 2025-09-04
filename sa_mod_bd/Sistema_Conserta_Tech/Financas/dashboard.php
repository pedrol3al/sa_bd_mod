    <?php
    session_start();
    require_once("../Conexao/conexao.php");
    require_once("finance_functions.php");

    // Buscar dados iniciais
    $periodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : 30;
    $receitaTotal = getReceitaTotal($pdo, $periodo);
    $despesasTotal = getDespesasTotal($pdo, $periodo);
    
    $lucroLiquido = $receitaTotal - $despesasTotal;
    // Garante que nunca fique negativo
    $lucroLiquido = max(0, $lucroLiquido);
    
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

    // Buscar dados para gráficos
    $dadosGraficoReceita = [];
    $dadosGraficoDespesas = [];
    $dadosStatus = ['total' => 0, 'concluidas' => 0, 'pendentes' => 0];

    try {
        // Dados para gráfico de receita (exemplo simplificado)
        $query = "SELECT 
                    DATE_FORMAT(os.data_criacao, '%Y-%m') as mes,
                    COALESCE(SUM(s.valor), 0) as receita
                FROM ordens_servico os
                LEFT JOIN equipamentos_os e ON os.id = e.id_os
                LEFT JOIN servicos_os s ON e.id = s.id_equipamento
                WHERE os.data_criacao >= DATE_SUB(NOW(), INTERVAL :periodo DAY)
                AND os.status = 'Concluído'
                GROUP BY DATE_FORMAT(os.data_criacao, '%Y-%m')
                ORDER BY mes";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
        $stmt->execute();
        $dadosGraficoReceita = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Dados para gráfico de despesas
        $query = "SELECT 
                    DATE_FORMAT(os.data_criacao, '%Y-%m') as mes,
                    COALESCE(SUM(op.valor_total), 0) as despesas
                FROM os_produto op
                INNER JOIN ordens_servico os ON op.id_os = os.id
                WHERE os.data_criacao >= DATE_SUB(NOW(), INTERVAL :periodo DAY)
                AND os.status = 'Concluído'
                GROUP BY DATE_FORMAT(os.data_criacao, '%Y-%m')
                ORDER BY mes";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
        $stmt->execute();
        $dadosGraficoDespesas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Dados de status
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN os.status = 'Concluído' THEN 1 ELSE 0 END) as concluidas,
                    SUM(CASE WHEN os.status != 'Concluído' THEN 1 ELSE 0 END) as pendentes
                FROM ordens_servico os";
        
        $stmt = $pdo->query($query);
        $dadosStatus = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        error_log("Erro ao buscar dados gráficos: " . $e->getMessage());
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
                        <div class="card-value" id="receita-total">R$ <?php echo number_format($receitaTotal, 2, ',', '.'); ?></div>
                        <div class="card-footer" id="variacao-receita">Valor total recebido (pagamentos concluídos)</div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Despesas</div>
                            <div class="card-icon despesa"><i class="bi bi-sort-down-alt"></i></div>
                        </div>
                        <div class="card-value" id="despesas-total">R$ <?php echo number_format($despesasTotal, 2, ',', '.'); ?></div>
                        <div class="card-footer" id="variacao-despesas">Custo das peças utilizadas</div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Lucro Líquido</div>
                            <div class="card-icon lucro"><i class="bi bi-reception-4"></i></div>
                        </div>
                        <div class="card-value" id="lucro-liquido">R$ <?php echo number_format($lucroLiquido, 2, ',', '.'); ?></div>
                        <div class="card-footer" id="variacao-lucro">Receita - Despesas</div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Pagamentos Pendentes</div>
                            <div class="card-icon pendente"><i class="bi bi-clock-history"></i></div>
                        </div>
                        <div class="card-value" id="pagamentos-pendentes">R$ <?php echo number_format($pagamentosPendentes, 2, ',', '.'); ?></div>
                        <div class="card-footer" id="quantidade-pendentes"><?php echo $quantidadePendentes; ?> ordens com pagamento pendente</div>
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
                ultimasOrdens: <?php echo json_encode($ultimasOrdens); ?>,
                dadosGraficoReceita: <?php echo json_encode($dadosGraficoReceita); ?>,
                dadosGraficoDespesas: <?php echo json_encode($dadosGraficoDespesas); ?>,
                dadosStatus: <?php echo json_encode($dadosStatus); ?>
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

                fetch('buscar_dados_dashboard.php?periodo=' + periodo + '&mes=' + mesSelecionado)
                    .then(response => response.json())
                    .then(data => {
                        if (data.sucesso) {
                            atualizarDashboard(data);
                        } else {
                            console.error('Erro ao carregar dados:', data.erro);
                            alert('Erro ao carregar dados: ' + data.erro);
                        }
                        toggleLoading(false);
                    })
                    .catch(error => {
                        console.error('Erro na requisição:', error);
                        alert('Erro ao carregar dados. Verifique o console para mais detalhes.');
                        toggleLoading(false);
                        usarDadosIniciais();
                    });
            }

            // Função para atualizar todo o dashboard
            function atualizarDashboard(data) {
                // Atualizar cards
                document.getElementById('receita-total').textContent = 'R$ ' + formatarValor(data.receitaTotal);
                document.getElementById('despesas-total').textContent = 'R$ ' + formatarValor(data.despesasTotal);
                document.getElementById('lucro-liquido').textContent = 'R$ ' + formatarValor(data.lucroLiquido);
                document.getElementById('pagamentos-pendentes').textContent = 'R$ ' + formatarValor(data.pagamentosPendentes);
                document.getElementById('quantidade-pendentes').textContent = data.quantidadePendentes + ' ordens com pagamento pendente';

                // Atualizar gráficos
                atualizarGraficos(data);
                
                // Atualizar tabela
                atualizarTabelaOS(data.ultimasOrdens);
            }

            // Função para atualizar os gráficos
            function atualizarGraficos(data) {
                // Gráfico de Receita vs Despesas
                const receitaMeses = data.dadosGraficoReceita.map(item => {
                    const [ano, mes] = item.mes.split('-');
                    return `${mes}/${ano}`;
                });
                const receitaValores = data.dadosGraficoReceita.map(item => parseFloat(item.receita || 0));
                
                const despesaMeses = data.dadosGraficoDespesas.map(item => {
                    const [ano, mes] = item.mes.split('-');
                    return `${mes}/${ano}`;
                });
                const despesaValores = data.dadosGraficoDespesas.map(item => parseFloat(item.despesas || 0));

                atualizarGraficoReceitaDespesas(receitaMeses, receitaValores, despesaMeses, despesaValores);

                // Gráfico de Status
                const total = data.dadosStatus.total || 1;
                const percentualPagos = ((data.dadosStatus.concluidas || 0) / total) * 100;
                const percentualPendentes = ((data.dadosStatus.pendentes || 0) / total) * 100;

                atualizarGraficoStatusPagamentos([percentualPagos, percentualPendentes]);
            }

            // Função para usar dados iniciais em caso de falha
            function usarDadosIniciais() {
                atualizarDashboard(dadosIniciais);
            }

            // Funções dos gráficos (mantenha as existentes)
            function atualizarGraficoReceitaDespesas(mesesReceita, receitas, mesesDespesas, despesas) {
                const ctx = document.getElementById('receitaDespesasChart').getContext('2d');
                
                if (receitaDespesasChart) {
                    receitaDespesasChart.destroy();
                }

                // Combinar meses únicos
                const todosMeses = [...new Set([...mesesReceita, ...mesesDespesas])].sort();
                
                // Mapear valores para meses correspondentes
                const receitaMap = new Map(mesesReceita.map((mes, i) => [mes, receitas[i]]));
                const despesaMap = new Map(mesesDespesas.map((mes, i) => [mes, despesas[i]]));
                
                const receitaData = todosMeses.map(mes => receitaMap.get(mes) || 0);
                const despesaData = todosMeses.map(mes => despesaMap.get(mes) || 0);

                receitaDespesasChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: todosMeses,
                        datasets: [
                            {
                                label: 'Receita',
                                data: receitaData,
                                backgroundColor: '#2ecc71',
                                borderColor: '#27ae60',
                                borderWidth: 1
                            },
                            {
                                label: 'Despesas',
                                data: despesaData,
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
                        }
                    }
                });
            }

            function atualizarGraficoStatusPagamentos(dados) {
                const ctx = document.getElementById('statusPagamentosChart').getContext('2d');
                
                if (statusPagamentosChart) {
                    statusPagamentosChart.destroy();
                }

                statusPagamentosChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pagos', 'Pendentes'],
                        datasets: [{
                            data: dados,
                            backgroundColor: ['#2ecc71', '#f39c12'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' },
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

            function atualizarTabelaOS(dados) {
                const tabela = document.getElementById('tabela-os');
                
                if (!dados || dados.length === 0) {
                    tabela.innerHTML = '<tr><td colspan="5" style="text-align: center;">Nenhuma ordem de serviço encontrada</td></tr>';
                    return;
                }

                tabela.innerHTML = dados.map(item => `
                    <tr>
                        <td>OS-${item.id.toString().padStart(5, '0')}</td>
                        <td>${item.cliente || 'N/A'}</td>
                        <td>${new Date(item.data_criacao).toLocaleDateString('pt-BR')}</td>
                        <td>R$ ${formatarValor(item.valor_total)}</td>
                        <td><span class="status ${(item.status || '').toLowerCase()}">${item.status || 'N/A'}</span></td>
                    </tr>
                `).join('');
            }

            // Inicializar
            document.addEventListener('DOMContentLoaded', function () {
                const agora = new Date();
                document.getElementById('mesSelecionado').value = agora.toISOString().slice(0, 7);
                usarDadosIniciais();
            });
        </script>
    </body>
    </html>