<?php
session_start();
require_once("../Conexao/conexao.php");
require_once("finance_functions.php");

if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 4) {
    echo "<script>alert('Acesso negado!');window.location.href='../Principal/main.php'</script>";
    exit();
}

// Definir período padrão
$periodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : 30;
$mesSelecionado = isset($_GET['mes']) ? $_GET['mes'] : '';

// Buscar dados iniciais
$receitaTotal = getReceitaTotal($pdo, $periodo, $mesSelecionado);
$despesasTotal = getDespesasTotal($pdo, $periodo, $mesSelecionado);

$lucroLiquido = $receitaTotal - $despesasTotal;
// Garante que nunca fique negativo
$lucroLiquido = max(0, $lucroLiquido);

// Buscar pagamentos pendentes
$dadosPendentes = getPagamentosPendentesCorrigido($pdo, $periodo, $mesSelecionado);
$pagamentosPendentes = $dadosPendentes['total_valor'];
$quantidadePendentes = $dadosPendentes['total_os'];

// Buscar últimas ordens de serviço
try {
    $query = "SELECT os.id, c.nome as cliente, os.data_criacao, 
                        (SELECT COALESCE(SUM(valor), 0) 
                        FROM servicos_os s 
                        INNER JOIN equipamentos_os e ON s.id_equipamento = e.id 
                        WHERE e.id_os = os.id) as valor_total,
                        (SELECT CASE 
                            WHEN EXISTS (SELECT 1 FROM pagamento p WHERE p.id_os = os.id AND p.status = 'Concluído') 
                            THEN 'Pago' ELSE 'Pendente' END) as status 
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
$dadosStatus = ['total' => 0, 'pagas' => 0, 'pendentes' => 0];

try {
    // Dados para gráfico de receita
    $query = "SELECT 
                    DATE_FORMAT(os.data_criacao, '%Y-%m') as mes,
                    COALESCE(SUM(s.valor), 0) as receita
                FROM ordens_servico os
                LEFT JOIN equipamentos_os e ON os.id = e.id_os
                LEFT JOIN servicos_os s ON e.id = s.id_equipamento
                WHERE 1=1";
    
    if (!empty($mesSelecionado)) {
        $query .= " AND DATE_FORMAT(os.data_criacao, '%Y-%m') = :mes";
    } else {
        $query .= " AND os.data_criacao >= DATE_SUB(NOW(), INTERVAL :periodo DAY)";
    }
    
    $query .= " AND EXISTS (SELECT 1 FROM pagamento p WHERE p.id_os = os.id AND p.status = 'Concluído')
                GROUP BY DATE_FORMAT(os.data_criacao, '%Y-%m')
                ORDER BY mes";

    $stmt = $pdo->prepare($query);
    
    if (!empty($mesSelecionado)) {
        $stmt->bindValue(':mes', $mesSelecionado, PDO::PARAM_STR);
    } else {
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    $dadosGraficoReceita = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Dados para gráfico de despesas
    $query = "SELECT 
                    DATE_FORMAT(os.data_criacao, '%Y-%m') as mes,
                    COALESCE(SUM(op.valor_total), 0) as despesas
                FROM os_produto op
                INNER JOIN ordens_servico os ON op.id_os = os.id
                WHERE 1=1";
    
    if (!empty($mesSelecionado)) {
        $query .= " AND DATE_FORMAT(os.data_criacao, '%Y-%m') = :mes";
    } else {
        $query .= " AND os.data_criacao >= DATE_SUB(NOW(), INTERVAL :periodo DAY)";
    }
    
    $query .= " AND EXISTS (SELECT 1 FROM pagamento p WHERE p.id_os = os.id AND p.status = 'Concluído')
                GROUP BY DATE_FORMAT(os.data_criacao, '%Y-%m')
                ORDER BY mes";

    $stmt = $pdo->prepare($query);
    
    if (!empty($mesSelecionado)) {
        $stmt->bindValue(':mes', $mesSelecionado, PDO::PARAM_STR);
    } else {
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    $dadosGraficoDespesas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Dados de status
    $query = "SELECT 
                    COUNT(DISTINCT os.id) as total,
                    SUM(CASE WHEN EXISTS (SELECT 1 FROM pagamento p WHERE p.id_os = os.id AND p.status = 'Concluído') THEN 1 ELSE 0 END) as pagas,
                    SUM(CASE WHEN NOT EXISTS (SELECT 1 FROM pagamento p WHERE p.id_os = os.id AND p.status = 'Concluído') THEN 1 ELSE 0 END) as pendentes
                FROM ordens_servico os
                WHERE 1=1";
    
    if (!empty($mesSelecionado)) {
        $query .= " AND DATE_FORMAT(os.data_criacao, '%Y-%m') = :mes";
    } else {
        $query .= " AND os.data_criacao >= DATE_SUB(NOW(), INTERVAL :periodo DAY)";
    }

    $stmt = $pdo->prepare($query);
    
    if (!empty($mesSelecionado)) {
        $stmt->bindValue(':mes', $mesSelecionado, PDO::PARAM_STR);
    } else {
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    $dadosStatus = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    error_log("Erro ao buscar dados gráficos: " . $e->getMessage());
}

// Preparar dados do filtro para o JavaScript
$filtroData = [
    'tipo' => empty($mesSelecionado) ? 'periodo' : 'mes',
    'valor' => empty($mesSelecionado) ? $periodo : $mesSelecionado
];

if ($filtroData['tipo'] === 'mes') {
    $data = new DateTime($mesSelecionado . '-01');
    $filtroData['texto'] = ucfirst(strftime('%B de %Y', $data->getTimestamp()));
} else {
    $filtroData['texto'] = "Últimos $periodo dias";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Financeiro - Sistema de Assistência Técnica</title>

    <link rel="stylesheet" href="dashboard.css" />
    <!-- Links bootstrapt e css -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../Menu_lateral/css-home-bar.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Imagem no navegador -->
    <link rel="shortcut icon" href="../img/favicon-16x16.ico" type="image/x-icon">

    <!-- Link do gráfico  -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

    <!-- Link notfy -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <!-- Link das máscaras dos campos -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>

<body>
    <?php include("../Menu_lateral/menu.php"); ?>
    <div class="container">
        <div class="main-content">
            <div class="header">
                <h1 class="page-title">Dashboard Financeiro</h1>
                <div class="filter-options">
                    <select id="filtro-tipo">
                        <option value="periodo" <?php echo empty($mesSelecionado) ? 'selected' : ''; ?>>Período</option>
                        <option value="mes" <?php echo !empty($mesSelecionado) ? 'selected' : ''; ?>>Mês Específico</option>
                    </select>
                    
                    <div id="filtro-periodo" class="filtro-opcao" style="<?php echo empty($mesSelecionado) ? '' : 'display: none;'; ?>">
                        <select id="periodo">
                            <option value="7" <?php echo $periodo == 7 ? 'selected' : ''; ?>>Últimos 7 dias</option>
                            <option value="30" <?php echo $periodo == 30 ? 'selected' : ''; ?>>Últimos 30 dias</option>
                            <option value="90" <?php echo $periodo == 90 ? 'selected' : ''; ?>>Últimos 3 meses</option>
                            <option value="180" <?php echo $periodo == 180 ? 'selected' : ''; ?>>Últimos 6 meses</option>
                            <option value="365" <?php echo $periodo == 365 ? 'selected' : ''; ?>>Último ano</option>
                        </select>
                    </div>
                    
                    <div id="filtro-mes" class="filtro-opcao" style="<?php echo !empty($mesSelecionado) ? '' : 'display: none;'; ?>">
                        <input type="month" id="mesSelecionado" value="<?php echo !empty($mesSelecionado) ? $mesSelecionado : date('Y-m'); ?>">
                    </div>
                    
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
                    <div class="card-value" id="receita-total">R$
                        <?php echo number_format($receitaTotal, 2, ',', '.'); ?>
                    </div>
                    <div class="card-footer" id="variacao-receita">Valor total recebido (pagamentos concluídos)</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Despesas</div>
                        <div class="card-icon despesa"><i class="bi bi-sort-down-alt"></i></div>
                    </div>
                    <div class="card-value" id="despesas-total">R$
                        <?php echo number_format($despesasTotal, 2, ',', '.'); ?>
                    </div>
                    <div class="card-footer" id="variacao-despesas">Custo das peças utilizadas</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Lucro Líquido</div>
                        <div class="card-icon lucro"><i class="bi bi-reception-4"></i></div>
                    </div>
                    <div class="card-value" id="lucro-liquido">R$
                        <?php echo number_format($lucroLiquido, 2, ',', '.'); ?>
                    </div>
                    <div class="card-footer" id="variacao-lucro">Receita - Despesas</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Pagamentos Pendentes</div>
                        <div class="card-icon pendente"><i class="bi bi-clock-history"></i></div>
                    </div>
                    <div class="card-value" id="pagamentos-pendentes">R$
                        <?php echo number_format($pagamentosPendentes, 2, ',', '.'); ?>
                    </div>
                    <div class="card-footer" id="quantidade-pendentes"><?php echo $quantidadePendentes; ?> ordens com
                        pagamento pendente</div>
                </div>
            </div>

            <!-- Informações do filtro aplicado -->
            <div class="filtro-info" id="filtro-info">
                <i class="bi bi-funnel"></i> 
                <span id="filtro-texto">Filtro: <?php echo $filtroData['texto']; ?></span>
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
            dadosStatus: <?php echo json_encode($dadosStatus); ?>,
            filtroData: <?php echo json_encode($filtroData); ?>
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

        // Função para atualizar o texto do filtro aplicado
        function atualizarTextoFiltro(filtroData) {
            const filtroTexto = document.getElementById('filtro-texto');
            
            if (filtroData.texto) {
                filtroTexto.textContent = `Filtro: ${filtroData.texto}`;
            } else if (filtroData.tipo === 'periodo') {
                filtroTexto.textContent = `Filtro: Últimos ${filtroData.valor} dias`;
            } else if (filtroData.tipo === 'mes') {
                const data = new Date(filtroData.valor + '-01');
                const mes = data.toLocaleDateString('pt-BR', { month: 'long', year: 'numeric' });
                filtroTexto.textContent = `Filtro: ${mes.charAt(0).toUpperCase() + mes.slice(1)}`;
            }
        }

        // Função para carregar dados com base nos filtros
        function carregarDados() {
            const filtroTipo = document.getElementById('filtro-tipo').value;
            const periodo = document.getElementById('periodo').value;
            const mesSelecionado = document.getElementById('mesSelecionado').value;

            toggleLoading(true);

            // Montar URL com parâmetros
            let url = 'buscar_dados_dashboard.php?';
            url += `filtro=${filtroTipo}`;
            
            if (filtroTipo === 'periodo') {
                url += `&periodo=${periodo}`;
            } else if (filtroTipo === 'mes' && mesSelecionado) {
                url += `&mes=${mesSelecionado}`;
            }

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na resposta do servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.sucesso) {
                        // Atualizar cards
                        document.getElementById('receita-total').textContent = 'R$ ' + formatarValor(data.receitaTotal);
                        document.getElementById('despesas-total').textContent = 'R$ ' + formatarValor(data.despesasTotal);
                        document.getElementById('lucro-liquido').textContent = 'R$ ' + formatarValor(data.lucroLiquido);
                        document.getElementById('pagamentos-pendentes').textContent = 'R$ ' + formatarValor(data.pagamentosPendentes);
                        document.getElementById('quantidade-pendentes').textContent = data.quantidadePendentes + ' ordens com pagamento pendente';

                        // Atualizar tabela
                        atualizarTabelaOS(data.ultimasOrdens);

                        // Atualizar gráficos
                        atualizarGraficoReceitaDespesas(data.dadosGraficoReceita, data.dadosGraficoDespesas, data.filtroData);
                        atualizarGraficoStatusPagamentos(data.dadosStatus);

                        // Atualizar texto do filtro
                        atualizarTextoFiltro(data.filtroData);

                        // Mostrar notificação de sucesso
                        const notyf = new Notyf({
                            duration: 3000,
                            position: { x: 'right', y: 'top' }
                        });
                        notyf.success('Dados atualizados com sucesso!');
                    } else {
                        throw new Error(data.erro || 'Erro ao carregar dados');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    
                    const notyf = new Notyf({
                        duration: 5000,
                        position: { x: 'right', y: 'top' }
                    });
                    notyf.error('Erro ao carregar dados: ' + error.message);
                })
                .finally(() => {
                    toggleLoading(false);
                });
        }

        // Função para atualizar a tabela de ordens de serviço
        function atualizarTabelaOS(ordens) {
            const tabela = document.getElementById('tabela-os');
            tabela.innerHTML = '';

            if (ordens && ordens.length > 0) {
                ordens.forEach(ordem => {
                    const tr = document.createElement('tr');
                    
                    const numeroOS = 'OS-' + String(ordem.id).padStart(5, '0');
                    const dataFormatada = ordem.data_criacao ? new Date(ordem.data_criacao).toLocaleDateString('pt-BR') : 'N/A';
                    const valorFormatado = formatarValor(ordem.valor_total);
                    const statusClasse = ordem.status ? ordem.status.toLowerCase() : 'pendente';
                    const statusTexto = ordem.status || 'Pendente';

                    tr.innerHTML = `
                        <td>${numeroOS}</td>
                        <td>${ordem.cliente || 'N/A'}</td>
                        <td>${dataFormatada}</td>
                        <td>R$ ${valorFormatado}</td>
                        <td>
                            <span class="status ${statusClasse}">${statusTexto}</span>
                        </td>
                    `;
                    
                    tabela.appendChild(tr);
                });
            } else {
                const tr = document.createElement('tr');
                tr.innerHTML = '<td colspan="5" style="text-align: center;">Nenhuma ordem de serviço encontrada</td>';
                tabela.appendChild(tr);
            }
        }

        // Função para atualizar o gráfico de receita e despesas
        function atualizarGraficoReceitaDespesas(dadosReceita, dadosDespesas, filtroData) {
            const ctx = document.getElementById('receitaDespesasChart').getContext('2d');
            
            // Preparar dados
            let meses = [];
            let receitas = [];
            let despesas = [];

            // Se for filtro por mês específico
            if (filtroData.tipo === 'mes') {
                const mesSelecionado = filtroData.valor;
                const nomeMes = filtroData.texto || mesSelecionado;
                
                meses = [nomeMes];
                
                // Buscar receita do mês selecionado
                let receitaMes = 0;
                if (dadosReceita && dadosReceita.length > 0) {
                    const receitaEncontrada = dadosReceita.find(item => item.mes === mesSelecionado);
                    receitaMes = receitaEncontrada ? parseFloat(receitaEncontrada.receita || 0) : 0;
                }
                receitas = [receitaMes];
                
                // Buscar despesas do mês selecionado
                let despesaMes = 0;
                if (dadosDespesas && dadosDespesas.length > 0) {
                    const despesaEncontrada = dadosDespesas.find(item => item.mes === mesSelecionado);
                    despesaMes = despesaEncontrada ? parseFloat(despesaEncontrada.despesas || 0) : 0;
                }
                despesas = [despesaMes];
            } else {
                // Para períodos, usar todos os meses retornados
                const todosMeses = new Set();
                
                // Coletar meses da receita
                if (dadosReceita && dadosReceita.length > 0) {
                    dadosReceita.forEach(item => {
                        todosMeses.add(item.mes);
                    });
                }
                
                // Coletar meses das despesas
                if (dadosDespesas && dadosDespesas.length > 0) {
                    dadosDespesas.forEach(item => {
                        todosMeses.add(item.mes);
                    });
                }
                
                // Ordenar meses
                meses = Array.from(todosMeses).sort();
                
                // Formatar meses para exibição (MM/YYYY)
                meses = meses.map(mes => {
                    const [ano, mesNum] = mes.split('-');
                    return `${mesNum}/${ano}`;
                });
                
                // Preencher receitas
                receitas = meses.map(mesLabel => {
                    const partes = mesLabel.split('/');
                    const mesFormatado = `${partes[1]}-${partes[0].padStart(2, '0')}`;
                    
                    const receita = dadosReceita.find(item => item.mes === mesFormatado);
                    return receita ? parseFloat(receita.receita || 0) : 0;
                });
                
                // Preencher despesas
                despesas = meses.map(mesLabel => {
                    const partes = mesLabel.split('/');
                    const mesFormatado = `${partes[1]}-${partes[0].padStart(2, '0')}`;
                    
                    const despesa = dadosDespesas.find(item => item.mes === mesFormatado);
                    return despesa ? parseFloat(despesa.despesas || 0) : 0;
                });
            }

            // Se não houver dados, mostrar mensagem
            if (meses.length === 0 || (receitas.every(r => r === 0) && despesas.every(d => d === 0))) {
                meses = ['Nenhum dado encontrado'];
                receitas = [0];
                despesas = [0];
            }

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
                            backgroundColor: 'rgba(40, 167, 69, 0.7)',
                            borderColor: 'rgba(40, 167, 69, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Despesas',
                            data: despesas,
                            backgroundColor: 'rgba(220, 53, 69, 0.7)',
                            borderColor: 'rgba(220, 53, 69, 1)',
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
                                    return 'R$ ' + value.toLocaleString('pt-BR', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += 'R$ ' + context.raw.toLocaleString('pt-BR', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Função para atualizar o gráfico de status de pagamentos
        function atualizarGraficoStatusPagamentos(dadosStatus) {
            const ctx = document.getElementById('statusPagamentosChart').getContext('2d');
            
            // Preparar dados
            const total = parseInt(dadosStatus.total || 0);
            const pagas = parseInt(dadosStatus.pagas || 0);
            const pendentes = parseInt(dadosStatus.pendentes || 0);

            // Destruir gráfico existente se houver
            if (statusPagamentosChart) {
                statusPagamentosChart.destroy();
            }

            // Criar novo gráfico
            statusPagamentosChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Concluídas', 'Pendentes'],
                    datasets: [{
                        data: [pagas, pendentes],
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.7)',
                            'rgba(255, 193, 7, 0.7)'
                        ],
                        borderColor: [
                            'rgba(40, 167, 69, 1)',
                            'rgba(255, 193, 7, 1)'
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
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Inicializar a página
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar gráficos com dados iniciais  
            atualizarGraficoReceitaDespesas(
                dadosIniciais.dadosGraficoReceita,
                dadosIniciais.dadosGraficoDespesas,
                dadosIniciais.filtroData
            );
            
            atualizarGraficoStatusPagamentos(dadosIniciais.dadosStatus);
            
            // Configurar evento de mudança no tipo de filtro
            document.getElementById('filtro-tipo').addEventListener('change', function() {
                const tipo = this.value;
                document.getElementById('filtro-periodo').style.display = tipo === 'periodo' ? 'block' : 'none';
                document.getElementById('filtro-mes').style.display = tipo === 'mes' ? 'block' : 'none';
            });

            // Atualizar texto do filtro inicial
            atualizarTextoFiltro(dadosIniciais.filtroData);
        });
    </script>
</body>

</html>