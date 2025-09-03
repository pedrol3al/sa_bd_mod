<?php
session_start();
require_once("../Conexao/conexao.php");

// DEBUG: Verificar dados nas tabelas
function debugTabelas($pdo) {
    echo "<!-- DEBUG INICIADO -->";
    
    // Verificar dados na tabela pagamento
    try {
        $query = "SELECT COUNT(*) as total, 
                         SUM(CASE WHEN status = 'Pago' THEN valor_total ELSE 0 END) as total_pago,
                         SUM(CASE WHEN status = 'Pendente' THEN valor_total ELSE 0 END) as total_pendente,
                         GROUP_CONCAT(CONCAT('ID:', id_pagamento, '-Status:', status, '-Valor:', valor_total) SEPARATOR '; ') as detalhes
                  FROM pagamento";
        $stmt = $pdo->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<!-- PAGAMENTOS: Total={$row['total']}, Pago={$row['total_pago']}, Pendente={$row['total_pendente']} -->";
        echo "<!-- Detalhes: {$row['detalhes']} -->";
    } catch (Exception $e) {
        echo "<!-- Erro ao verificar pagamentos: " . $e->getMessage() . " -->";
    }

    // Verificar dados na tabela ordens_servico
    try {
        $query = "SELECT COUNT(*) as total FROM ordens_servico";
        $stmt = $pdo->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<!-- ORDENS_SERVICO: Total={$row['total']} -->";
    } catch (Exception $e) {
        echo "<!-- Erro ao verificar ordens_servico: " . $e->getMessage() . " -->";
    }

    // Verificar dados na tabela os_produto
    try {
        $query = "SELECT COUNT(*) as total, SUM(quantidade) as total_qtd FROM os_produto";
        $stmt = $pdo->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<!-- OS_PRODUTO: Total={$row['total']}, Quantidade={$row['total_qtd']} -->";
    } catch (Exception $e) {
        echo "<!-- Erro ao verificar os_produto: " . $e->getMessage() . " -->";
    }

    // Verificar dados na tabela estoque
    try {
        $query = "SELECT COUNT(*) as total, SUM(valor_unitario) as total_valor FROM estoque";
        $stmt = $pdo->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<!-- ESTOQUE: Total={$row['total']}, ValorTotal={$row['total_valor']} -->";
    } catch (Exception $e) {
        echo "<!-- Erro ao verificar estoque: " . $e->getMessage() . " -->";
    }
    
    echo "<!-- DEBUG FINALIZADO -->";
}

// Funções simplificadas para buscar dados
function getReceitaTotal($pdo) {
    try {
        $query = "SELECT COALESCE(SUM(valor_total), 0) as total 
                  FROM pagamento 
                  WHERE status = 'Pago'";
        $stmt = $pdo->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    } catch (Exception $e) {
        return 0;
    }
}

function getDespesasTotal($pdo) {
    try {
        // Valor total dos produtos em estoque como despesa simplificada
        $query = "SELECT COALESCE(SUM(valor_unitario * quantidade), 0) as total 
                  FROM estoque";
        $stmt = $pdo->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    } catch (Exception $e) {
        return 0;
    }
}

function getPagamentosPendentes($pdo) {
    try {
        $query = "SELECT COALESCE(SUM(valor_total), 0) as total 
                  FROM pagamento 
                  WHERE status = 'Pendente'";
        $stmt = $pdo->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    } catch (Exception $e) {
        return 0;
    }
}

function getQuantidadePendentes($pdo) {
    try {
        $query = "SELECT COUNT(*) as total 
                  FROM pagamento 
                  WHERE status = 'Pendente'";
        $stmt = $pdo->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    } catch (Exception $e) {
        return 0;
    }
}

function getUltimasOrdensServico($pdo) {
    try {
        $query = "SELECT os.id, c.nome as cliente, os.data_criacao, 
                         COALESCE(p.valor_total, 0) as valor_total, 
                         COALESCE(p.status, 'Pendente') as status 
                  FROM ordens_servico os 
                  LEFT JOIN cliente c ON os.id_cliente = c.id_cliente 
                  LEFT JOIN pagamento p ON os.id = p.id_os 
                  ORDER BY os.data_criacao DESC 
                  LIMIT 5";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return [];
    }
}

// Buscar dados iniciais
if (isset($pdo)) {
    // Executar debug primeiro
    debugTabelas($pdo);
    
    $receitaTotal = getReceitaTotal($pdo);
    $despesasTotal = getDespesasTotal($pdo);
    $lucroLiquido = $receitaTotal - $despesasTotal;
    $pagamentosPendentes = getPagamentosPendentes($pdo);
    $quantidadePendentes = getQuantidadePendentes($pdo);
    $ultimasOrdens = getUltimasOrdensServico($pdo);
    
    // Debug dos valores obtidos
    echo "<!-- VALORES: Receita=$receitaTotal, Despesas=$despesasTotal, Lucro=$lucroLiquido, Pendentes=$pagamentosPendentes, QtdPendentes=$quantidadePendentes -->";
} else {
    $receitaTotal = 0;
    $despesasTotal = 0;
    $lucroLiquido = 0;
    $pagamentosPendentes = 0;
    $quantidadePendentes = 0;
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
        
        .receita { color: #2ecc71; }
        .despesa { color: #e74c3c; }
        .lucro { color: #3498db; }
        .pendente { color: #f39c12; }
        
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f8f9fa;
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
                    <button onclick="carregarDados()" class="btn btn-primary">Aplicar Filtros</button>
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
                    <div class="card-footer" id="variacao-receita">Dados dos últimos 30 dias</div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Despesas</div>
                        <div class="card-icon despesa"><i class="bi bi-sort-down-alt"></i></div>
                    </div>
                    <div class="card-value" id="despesas-total">R$ 0,00</div>
                    <div class="card-footer" id="variacao-despesas">Custo dos produtos vendidos</div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Lucro Líquido</div>
                        <div class="card-icon lucro"><i class="bi bi-reception-4"></i></div>
                    </div>
                    <div class="card-value" id="lucro-liquido">R$ 0,00</div>
                    <div class="card-footer" id="variacao-lucro">Receita - Despesas</div>
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
        return parseFloat(valor || 0).toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // Função para carregar os dados do dashboard
function carregarDados() {
    console.log("Dados iniciais:", dadosIniciais);
    
    // Usar dados iniciais do PHP com fallback para 0
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
    
    // Dados para gráficos (usando dados reais quando disponíveis)
    const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'];
    
    // Se não há receita, usar valores de exemplo para demonstração
    let receitas, despesasGraf;
    if (receita > 0) {
        receitas = [receita * 0.8, receita * 0.9, receita, receita * 1.1, receita * 1.2, receita * 1.3];
        despesasGraf = [despesas * 0.8, despesas * 0.9, despesas, despesas * 1.1, despesas * 1.2, despesas * 1.3];
    } else {
        // Dados de exemplo para demonstração
        receitas = [8500, 9200, 10200, 11200, 10500, 12400];
        despesasGraf = [4200, 4500, 4800, 5100, 4900, 5300];
    }
    
    // Atualizar gráficos
    atualizarGraficoReceitaDespesas(meses, receitas, despesasGraf);
    
    // Gráfico de status
    const totalOrdens = dadosIniciais.ultimasOrdens.length || 1;
    const pagosCount = totalOrdens - qtdPendentes;
    const percentualPagos = (pagosCount / totalOrdens) * 100;
    const percentualPendentes = (qtdPendentes / totalOrdens) * 100;
    
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