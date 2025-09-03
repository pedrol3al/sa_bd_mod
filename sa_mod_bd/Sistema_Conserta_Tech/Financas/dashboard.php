<?php
    session_start();
    require_once("../Conexao/conexao.php");

    $sql="SELECT cliente SET nome=:nome, email=:email WHERE id_cliente=:id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT);
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

        // Função para carregar os dados do dashboard
        function carregarDados() {
            const periodo = document.getElementById('periodo').value;
            const mes = document.getElementById('mesSelecionado').value;
            
            // Simulação de dados - na implementação real, isso virá do PHP
            simularDadosDashboard(periodo, mes);
        }

        // Função para simular dados (substituir por chamadas PHP reais)
        function simularDadosDashboard(periodo, mes) {
            // Simular dados dos cards
            document.getElementById('receita-total').textContent = 'R$ 12.456,00';
            document.getElementById('despesas-total').textContent = 'R$ 5.234,00';
            document.getElementById('lucro-liquido').textContent = 'R$ 7.222,00';
            document.getElementById('pagamentos-pendentes').textContent = 'R$ 3.450,00';
            
            document.getElementById('variacao-receita').textContent = '+15% em relação ao período anterior';
            document.getElementById('variacao-despesas').textContent = '+5% em relação ao período anterior';
            document.getElementById('variacao-lucro').textContent = '+22% em relação ao período anterior';
            document.getElementById('quantidade-pendentes').textContent = '12 ordens com pagamento pendente';
            
            // Simular dados para os gráficos
            const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
            const receitas = [8500, 9200, 10200, 11200, 10500, 12400, 13200, 14500, 13000, 14200, 15800, 16400];
            const despesas = [4200, 4500, 4800, 5100, 4900, 5300, 5600, 5900, 5400, 5800, 6100, 6300];
            
            // Atualizar gráfico de receitas e despesas
            atualizarGraficoReceitaDespesas(meses, receitas, despesas);
            
            // Atualizar gráfico de status de pagamentos
            atualizarGraficoStatusPagamentos([65, 25, 10]);
            
            // Simular dados da tabela
            const ordensServico = [
                { id: 'OS-00125', cliente: 'Maria Silva', data: '15/08/2023', valor: 'R$ 450,00', status: 'pago' },
                { id: 'OS-00124', cliente: 'João Santos', data: '14/08/2023', valor: 'R$ 320,00', status: 'pendente' },
                { id: 'OS-00123', cliente: 'Empresa XYZ Ltda', data: '13/08/2023', valor: 'R$ 1.250,00', status: 'pago' },
                { id: 'OS-00122', cliente: 'Ana Costa', data: '12/08/2023', valor: 'R$ 280,00', status: 'atrasado' },
                { id: 'OS-00121', cliente: 'Carlos Oliveira', data: '11/08/2023', valor: 'R$ 520,00', status: 'pago' }
            ];
            
            atualizarTabelaOS(ordensServico);
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
                    labels: ['Pagos', 'Pendentes', 'Atrasados'],
                    datasets: [{
                        data: dados,
                        backgroundColor: [
                            '#2ecc71',
                            '#f39c12',
                            '#e74c3c'
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
                                    return context.label + ': ' + context.raw + '%';
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
            
            dados.forEach(item => {
                const tr = document.createElement('tr');
                
                tr.innerHTML = `
                    <td>${item.id}</td>
                    <td>${item.cliente}</td>
                    <td>${item.data}</td>
                    <td>${item.valor}</td>
                    <td><span class="status ${item.status}">${item.status.charAt(0).toUpperCase() + item.status.slice(1)}</span></td>
                `;
                
                tabela.appendChild(tr);
            });
        }

        // Inicializar o dashboard quando a página carregar
        document.addEventListener('DOMContentLoaded', function() {
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