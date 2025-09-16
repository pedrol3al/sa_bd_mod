<?php
// finance_functions.php

function getReceitaTotal($pdo, $periodo) {
    $timezone = new DateTimeZone('America/Sao_Paulo');
    $dataAtual = new DateTime('now', $timezone);
    
    try {
        $query = "SELECT COALESCE(SUM(p.valor_total), 0) as total_receita
                  FROM pagamento p
                  WHERE p.status = 'Concluído'
                  AND p.data_pagamento >= DATE_SUB(:data_atual, INTERVAL :periodo DAY)";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
        $stmt->bindValue(':data_atual', $dataAtual->format('Y-m-d H:i:s'));
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['total_receita'] > 0) {
            return $result['total_receita'];
        }
    } catch (Exception $e) {
        error_log("Erro ao buscar pagamentos: " . $e->getMessage());
    }
    
    $query = "SELECT COALESCE(SUM(s.valor), 0) as total_receita
              FROM servicos_os s
              INNER JOIN equipamentos_os e ON s.id_equipamento = e.id
              INNER JOIN ordens_servico os ON e.id_os = os.id
              WHERE os.data_criacao >= DATE_SUB(:data_atual, INTERVAL :periodo DAY)
              AND os.status = 'Concluído'";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
    $stmt->bindValue(':data_atual', $dataAtual->format('Y-m-d H:i:s'));
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_receita'];
}

function getDespesasTotal($pdo, $periodo) {
    $timezone = new DateTimeZone('America/Sao_Paulo');
    $dataAtual = new DateTime('now', $timezone);

    try {
        $query = "SELECT COALESCE(SUM(op.valor_total), 0) as total_despesas
                  FROM os_produto op
                  INNER JOIN ordens_servico os ON op.id_os = os.id
                  WHERE os.data_criacao >= DATE_SUB(:data_atual, INTERVAL :periodo DAY)";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
        $stmt->bindValue(':data_atual', $dataAtual->format('Y-m-d H:i:s'));
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return abs((float) $result['total_despesas']);

    } catch (Exception $e) {
        error_log("Erro ao buscar despesas de OS: " . $e->getMessage());
        return 0;
    }
}

function getDadosGraficoDespesas($pdo, $periodo) {
    $timezone = new DateTimeZone('America/Sao_Paulo');
    $dataAtual = new DateTime('now', $timezone);

    try {
        $query = "SELECT 
                    DATE_FORMAT(os.data_criacao, '%Y-%m') as mes,
                    COALESCE(SUM(op.valor_total), 0) as despesas
                  FROM os_produto op
                  INNER JOIN ordens_servico os ON op.id_os = os.id
                  WHERE os.data_criacao >= DATE_SUB(:data_atual, INTERVAL :periodo DAY)
                  GROUP BY DATE_FORMAT(os.data_criacao, '%Y-%m')
                  ORDER BY mes";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
        $stmt->bindValue(':data_atual', $dataAtual->format('Y-m-d H:i:s'));
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        error_log("Erro ao buscar gráfico de despesas de OS: " . $e->getMessage());
        return [];
    }
}

// Função getPagamentosPendentesCorrigido - ADICIONADA PARA RESOLVER O ERRO
function getPagamentosPendentesCorrigido($pdo) {
    try {
        // Buscar valor total de serviços de OS não concluídas OU com pagamentos pendentes
        $query = "SELECT 
                    COUNT(DISTINCT os.id) as total_os,
                    COALESCE(SUM(
                        (SELECT COALESCE(SUM(s.valor), 0) 
                         FROM servicos_os s 
                         INNER JOIN equipamentos_os e ON s.id_equipamento = e.id 
                         WHERE e.id_os = os.id)
                    ), 0) as total_valor
                  FROM ordens_servico os
                  WHERE os.status != 'Concluído' 
                  OR os.id IN (
                      SELECT p.id_os 
                      FROM pagamento p 
                      WHERE p.status != 'Concluído' 
                      OR p.id_os NOT IN (
                          SELECT id_os FROM pagamento WHERE status = 'Concluído'
                      )
                  )";
        
        $stmt = $pdo->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
        
    } catch (Exception $e) {
        error_log("Erro ao buscar pagamentos pendentes: " . $e->getMessage());
        return ['total_os' => 0, 'total_valor' => 0];
    }
}

function getPagamentosPendentes($pdo) {
    // Primeiro, tente buscar da tabela de pagamentos se existir
    try {
        $query = "SELECT COALESCE(SUM(valor_total), 0) as total_pendente
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
    try {
        $query = "SELECT COUNT(DISTINCT id_os) as total_pendentes
                  FROM pagamento 
                  WHERE status != 'Concluído'";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['total_pendentes'] > 0) {
            return $result['total_pendentes'];
        }
    } catch (Exception $e) {
        error_log("Erro ao buscar quantidade de pendentes: " . $e->getMessage());
    }
    
    // Fallback: contar OS não concluídas
    $query = "SELECT COUNT(DISTINCT os.id) as total_pendentes
              FROM ordens_servico os
              WHERE os.status != 'Concluído'";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_pendentes'];
}

function getDadosGraficoReceita($pdo, $periodo) {
    $timezone = new DateTimeZone('America/Sao_Paulo');
    $dataAtual = new DateTime('now', $timezone);
    
    // Primeiro, tente buscar da tabela de pagamentos se existir
    try {
        $query = "SELECT 
                    DATE_FORMAT(p.data_pagamento, '%Y-%m') as mes,
                    COALESCE(SUM(p.valor_total), 0) as receita
                  FROM pagamento p
                  WHERE p.status = 'Concluído'
                  AND p.data_pagamento >= DATE_SUB(:data_atual, INTERVAL :periodo DAY)
                  GROUP BY DATE_FORMAT(p.data_pagamento, '%Y-%m')
                  ORDER BY mes";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
        $stmt->bindValue(':data_atual', $dataAtual->format('Y-m-d H:i:s'));
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
              WHERE os.data_criacao >= DATE_SUB(:data_atual, INTERVAL :periodo DAY)
              AND os.status = 'Concluído'
              GROUP BY DATE_FORMAT(os.data_criacao, '%Y-%m')
              ORDER BY mes";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
    $stmt->bindValue(':data_atual', $dataAtual->format('Y-m-d H:i:s'));
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDadosStatusPagamentos($pdo) {
    // Primeiro, tente usar a tabela de pagamentos
    try {
        $query = "SELECT 
                    COUNT(DISTINCT id_os) as total,
                    SUM(CASE WHEN status = 'Concluído' THEN 1 ELSE 0 END) as concluidas,
                    SUM(CASE WHEN status != 'Concluído' THEN 1 ELSE 0 END) as pendentes
                  FROM pagamento";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Se falhar, use a lógica alternativa baseada no status da OS
        error_log("Erro ao buscar status pagamentos: " . $e->getMessage());
        
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN os.status = 'Concluído' THEN 1 ELSE 0 END) as concluidas,
                    SUM(CASE WHEN os.status != 'Concluído' THEN 1 ELSE 0 END) as pendentes
                  FROM ordens_servico os";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
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

function getValorTotalOS($pdo, $id_os) {
    try {
        $query = "SELECT COALESCE(SUM(s.valor), 0) as valor_total
                  FROM servicos_os s
                  INNER JOIN equipamentos_os e ON s.id_equipamento = e.id
                  WHERE e.id_os = :id_os";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id_os', $id_os, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['valor_total'];
        
    } catch (Exception $e) {
        error_log("Erro ao calcular valor total da OS: " . $e->getMessage());
        return 0;
    }
}

/**
 * Calcula o valor já pago de uma Ordem de Serviço
 */
function getValorPagoOS($pdo, $id_os) {
    try {
       $query = "SELECT COALESCE(SUM(valor_total), 0) as valor_pago
          FROM pagamento 
          WHERE id_os = :id_os 
          AND status = 'Concluído'";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id_os', $id_os, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['valor_pago'];
        
    } catch (Exception $e) {
        error_log("Erro ao calcular valor pago da OS: " . $e->getMessage());
        return 0;
    }
}

/**
 * Atualiza o status da OS baseado nos pagamentos
 */
function atualizarStatusOS($pdo, $id_os) {
    try {
        $valor_total = getValorTotalOS($pdo, $id_os);
        $valor_pago = getValorPagoOS($pdo, $id_os);
        
        $novo_status = '';
        
        if ($valor_pago >= $valor_total) {
            $novo_status = 'Concluído';
        } else if ($valor_pago > 0) {
            $novo_status = 'Parcialmente Pago';
        } else {
            $novo_status = 'Pendente';
        }
        
        $query = "UPDATE ordens_servico 
                  SET status = :status 
                  WHERE id = :id_os";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':status', $novo_status);
        $stmt->bindValue(':id_os', $id_os, PDO::PARAM_INT);
        $stmt->execute();
        
    } catch (Exception $e) {
        error_log("Erro ao atualizar status da OS: " . $e->getMessage());
    }
}

/**
 * Busca informações detalhadas de uma OS para pagamento
 */
function getInfoOSParaPagamento($pdo, $id_os) {
    try {
        $query = "SELECT 
                    os.id,
                    c.nome as cliente,
                    os.status as status_os,
                    (SELECT COALESCE(SUM(s.valor), 0) 
                     FROM servicos_os s 
                     INNER JOIN equipamentos_os e ON s.id_equipamento = e.id 
                     WHERE e.id_os = os.id) as valor_total,
                    (SELECT COALESCE(SUM(p.valor_total), 0) 
                     FROM pagamento p 
                     WHERE p.id_os = os.id AND p.status = 'Concluído') as valor_pago
                  FROM ordens_servico os
                  INNER JOIN cliente c ON os.id_cliente = c.id_cliente
                  WHERE os.id = :id_os";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id_os', $id_os, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        error_log("Erro ao buscar informações da OS: " . $e->getMessage());
        return false;
    }
}

/**
 * Busca histórico de pagamentos de uma OS
 */
function getHistoricoPagamentosOS($pdo, $id_os) {
    try {
        $query = "SELECT 
                    id_pagamento,
                    valor_total,
                    frm_pagamento,
                    data_pagamento,
                    status
                  FROM pagamento 
                  WHERE id_os = :id_os 
                  ORDER BY data_pagamento DESC";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id_os', $id_os, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (Exception $e) {
        error_log("Erro ao buscar histórico de pagamentos: " . $e->getMessage());
        return [];
    }
}
?>