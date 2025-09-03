<?php
session_start();
require_once("../Conexao/conexao.php");

// Funções de busca de dados
function getReceitaTotal($pdo, $periodo) {
    // Primeiro, tente buscar da tabela de pagamentos se existir
    try {
        $query = "SELECT COALESCE(SUM(p.valor), 0) as total_receita
                  FROM pagamento p
                  INNER JOIN ordens_servico os ON p.id_os = os.id
                  WHERE p.status = 'Concluído'
                  AND p.data_pagamento >= DATE_SUB(NOW(), INTERVAL :periodo DAY)";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Se encontrou valores na tabela de pagamentos, retorne
        if ($result['total_receita'] > 0) {
            return $result['total_receita'];
        }
    } catch (Exception $e) {
        // Se a tabela pagamento não existir ou houver erro, continue com a lógica alternativa
        error_log("Erro ao buscar pagamentos: " . $e->getMessage());
    }
    
    // Se não encontrou na tabela de pagamentos, use a lógica alternativa
    // (somente ordens de serviço concluídas)
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

function getDespesasTotal($pdo, $periodo) {
    // Como não há tabela de despesas, vamos estimar como 30% da receita
    $receita = getReceitaTotal($pdo, $periodo);
    return $receita * 0.3;
}

function getPagamentosPendentes($pdo) {
    // Primeiro, tente buscar da tabela de pagamentos se existir
    try {
        $query = "SELECT COALESCE(SUM(valor), 0) as total_pendente
                  FROM pagamento 
                  WHERE status != 'Concluído'";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Se encontrou valores na tabela de pagamentos, retorne
        if ($result['total_pendente'] > 0) {
            return $result['total_pendente'];
        }
    } catch (Exception $e) {
        // Se a tabela pagamento não existir, continue com a lógica alternativa
        error_log("Erro ao buscar pagamentos pendentes: " . $e->getMessage());
    }
    
    // Lógica alternativa: soma dos valores de serviços onde a OS não está concluída
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

function getQuantidadePendentes($pdo) {
    // Primeiro, tente buscar da tabela de pagamentos se existir
    try {
        $query = "SELECT COUNT(DISTINCT id_os) as total_pendentes
                  FROM pagamento 
                  WHERE status != 'Concluído'";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Se encontrou valores na tabela de pagamentos, retorne
        if ($result['total_pendentes'] > 0) {
            return $result['total_pendentes'];
        }
    } catch (Exception $e) {
        // Se a tabela pagamento não existir, continue com a lógica alternativa
        error_log("Erro ao buscar quantidade de pendentes: " . $e->getMessage());
    }
    
    // Lógica alternativa: contar OS não concluídas
    $query = "SELECT COUNT(DISTINCT os.id) as total_pendentes
              FROM ordens_servico os
              WHERE os.status != 'Concluído'";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_pendentes'];
}

function getDadosGraficoReceita($pdo, $periodo) {
    // Primeiro, tente buscar da tabela de pagamentos se existir
    try {
        $query = "SELECT 
                    DATE_FORMAT(p.data_pagamento, '%Y-%m') as mes,
                    COALESCE(SUM(p.valor), 0) as receita
                  FROM pagamento p
                  WHERE p.status = 'Concluído'
                  AND p.data_pagamento >= DATE_SUB(NOW(), INTERVAL :periodo DAY)
                  GROUP BY DATE_FORMAT(p.data_pagamento, '%Y-%m')
                  ORDER BY mes";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Se encontrou valores na tabela de pagamentos, retorne
        if (!empty($result)) {
            return $result;
        }
    } catch (Exception $e) {
        // Se a tabela pagamento não existir, continue com a lógica alternativa
        error_log("Erro ao buscar dados gráfico: " . $e->getMessage());
    }
    
    // Lógica alternativa: buscar por data de criação da OS
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

function getUltimasOrdens($pdo, $limite = 5) {
    // Primeiro, tente usar a tabela de pagamentos se existir
    try {
        $query = "SELECT 
                    os.id, 
                    c.nome as cliente, 
                    os.data_criacao, 
                    COALESCE(SUM(s.valor), 0) as valor_total,
                    CASE 
                        WHEN EXISTS (SELECT 1 FROM pagamento p WHERE p.id_os = os.id AND p.status = 'Concluído') 
                        THEN 'Pago' 
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
    } catch (Exception $e) {
        // Se falhar, use a lógica alternativa baseada apenas no status da OS
        error_log("Erro ao buscar últimas ordens: " . $e->getMessage());
        
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
}



// Buscar dados com período informado
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