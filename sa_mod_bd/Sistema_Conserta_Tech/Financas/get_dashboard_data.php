<?php
// Incluir arquivo de conexão
require_once("../Conexao/conexao.php");

// Função para buscar a receita total
function getReceitaTotal($pdo, $periodo) {
    $query = "SELECT COALESCE(SUM(s.valor), 0) as total_receita
              FROM servicos_os s
              INNER JOIN equipamentos_os e ON s.id_equipamento = e.id
              INNER JOIN ordens_servico os ON e.id_os = os.id
              WHERE os.data_criacao >= DATE_SUB(NOW(), INTERVAL :periodo DAY)
              AND os.status = 'Concluído'";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_receita'];
}

// Função para buscar despesas totais (como não há tabela de despesas, retornar 0)
function getDespesasTotal($pdo, $periodo) {
    // Como não há tabela de despesas no banco de dados fornecido,
    // vamos retornar um valor fixo de 30% da receita como despesas estimadas
    $receita = getReceitaTotal($pdo, $periodo);
    return $receita * 0.3; // 30% da receita como despesas estimadas
}

// Função para buscar pagamentos pendentes
function getPagamentosPendentes($pdo) {
    $query = "SELECT COALESCE(SUM(s.valor), 0) as total_pendente
              FROM servicos_os s
              INNER JOIN equipamentos_os e ON s.id_equipamento = e.id
              INNER JOIN ordens_servico os ON e.id_os = os.id
              WHERE os.status != 'Concluído'";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_pendente'];
}

// Função para buscar quantidade de OS com pagamentos pendentes
function getQuantidadePendentes($pdo) {
    $query = "SELECT COUNT(DISTINCT os.id) as total_pendentes
              FROM ordens_servico os
              WHERE os.status != 'Concluído'";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_pendentes'];
}

// Função para buscar dados para o gráfico de receita por mês
function getDadosGraficoReceita($pdo, $periodo) {
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
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para buscar dados para o gráfico de status de pagamentos
function getDadosStatusPagamentos($pdo) {
    $query = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN os.status = 'Concluído' THEN 1 ELSE 0 END) as concluidas,
                SUM(CASE WHEN os.status != 'Concluído' THEN 1 ELSE 0 END) as pendentes
              FROM ordens_servico os";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Função para buscar últimas ordens de serviço
function getUltimasOrdens($pdo, $limite = 5) {
    $query = "SELECT 
                os.id, 
                c.nome as cliente, 
                os.data_criacao, 
                COALESCE(SUM(s.valor), 0) as valor_total,
                CASE 
                    WHEN os.status = 'Concluído' THEN 'Pago' 
                    ELSE 'Pendente' 
                END as status
              FROM ordens_servico os
              LEFT JOIN cliente c ON os.id_cliente = c.id_cliente
              LEFT JOIN equipamentos_os e ON os.id = e.id_os
              LEFT JOIN servicos_os s ON e.id = s.id_equipamento
              GROUP BY os.id
              ORDER BY os.data_criacao DESC
              LIMIT :limite";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Buscar dados com período padrão de 30 dias
$periodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : 30;

try {
    $receitaTotal = getReceitaTotal($pdo, $periodo);
    $despesasTotal = getDespesasTotal($pdo, $periodo);
    $lucroLiquido = $receitaTotal - $despesasTotal;
    $pagamentosPendentes = getPagamentosPendentes($pdo);
    $quantidadePendentes = getQuantidadePendentes($pdo);
    $dadosGrafico = getDadosGraficoReceita($pdo, $periodo);
    $dadosStatus = getDadosStatusPagamentos($pdo);
    $ultimasOrdens = getUltimasOrdens($pdo, 5);
    
    // Preparar dados para retorno
    $dadosDashboard = [
        'receitaTotal' => $receitaTotal,
        'despesasTotal' => $despesasTotal,
        'lucroLiquido' => $lucroLiquido,
        'pagamentosPendentes' => $pagamentosPendentes,
        'quantidadePendentes' => $quantidadePendentes,
        'dadosGrafico' => $dadosGrafico,
        'dadosStatus' => $dadosStatus,
        'ultimasOrdens' => $ultimasOrdens,
        'periodo' => $periodo,
        'sucesso' => true
    ];
    
} catch (Exception $e) {
    // Em caso de erro, retornar mensagem de erro
    $dadosDashboard = [
        'sucesso' => false,
        'erro' => $e->getMessage()
    ];
}

// Retornar dados em formato JSON
header('Content-Type: application/json');
echo json_encode($dadosDashboard);
?>