<?php
// Habilitar exibição de erros para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once '../Conexao/conexao.php';

// Verificar se a conexão foi estabelecida
if (!isset($pdo) || !$pdo) {
    echo json_encode([
        'sucesso' => false,
        'erro' => "Falha na conexão com o banco de dados"
    ]);
    exit;
}

// DEBUG: Log dos parâmetros recebidos
error_log("Filtro: " . ($_GET['filtro'] ?? 'N/A'));
error_log("Período: " . ($_GET['periodo'] ?? 'N/A'));
error_log("Mês: " . ($_GET['mes'] ?? 'N/A'));

// Função para processar os parâmetros de data
function processarFiltroData($filtro, $periodo, $dataEspecifica) {
    $timezone = new DateTimeZone('America/Sao_Paulo');
    $dataAtual = new DateTime('now', $timezone);
    
    switch ($filtro) {
        case 'periodo':
            $dataInicio = clone $dataAtual;
            $dataInicio->sub(new DateInterval('P' . $periodo . 'D'));
            return [
                'data_inicio' => $dataInicio->format('Y-m-d 00:00:00'),
                'data_fim' => $dataAtual->format('Y-m-d 23:59:59'),
                'tipo' => 'periodo',
                'valor' => $periodo,
                'texto' => 'Últimos ' . $periodo . ' dias'
            ];
            
        case 'mes':
            if (!empty($dataEspecifica)) {
                $data = DateTime::createFromFormat('Y-m', $dataEspecifica, $timezone);
                if ($data) {
                    $dataInicio = clone $data;
                    $dataInicio->modify('first day of this month')->setTime(0, 0, 0);
                    
                    $dataFim = clone $data;
                    $dataFim->modify('last day of this month')->setTime(23, 59, 59);
                    
                    $mesFormatado = $data->format('F Y');
                    $mesFormatado = ucfirst(str_replace(
                        ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                        ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                        $mesFormatado
                    ));
                    
                    return [
                        'data_inicio' => $dataInicio->format('Y-m-d H:i:s'),
                        'data_fim' => $dataFim->format('Y-m-d H:i:s'),
                        'tipo' => 'mes',
                        'valor' => $dataEspecifica,
                        'texto' => $mesFormatado
                    ];
                }
            }
            break;
    }
    
    // Padrão: últimos 30 dias
    $dataInicio = clone $dataAtual;
    $dataInicio->sub(new DateInterval('P30D'));
    return [
        'data_inicio' => $dataInicio->format('Y-m-d 00:00:00'),
        'data_fim' => $dataAtual->format('Y-m-d 23:59:59'),
        'tipo' => 'periodo',
        'valor' => 30,
        'texto' => 'Últimos 30 dias'
    ];
}

// Funções de busca de dados com suporte a filtro de data
function getReceitaTotal($pdo, $filtroData) {
    try {
        // DEBUG: Log da consulta
        error_log("Buscando receita entre: " . $filtroData['data_inicio'] . " e " . $filtroData['data_fim']);
        
        // Primeiro tenta buscar da tabela de pagamentos
        $query = "SELECT COALESCE(SUM(p.valor_total), 0) as total_receita
                  FROM pagamento p
                  WHERE p.status = 'Concluído'
                  AND p.data_pagamento BETWEEN :data_inicio AND :data_fim";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':data_inicio', $filtroData['data_inicio']);
        $stmt->bindValue(':data_fim', $filtroData['data_fim']);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        error_log("Receita de pagamentos: " . $result['total_receita']);
        
        if ($result['total_receita'] > 0) {
            return $result['total_receita'];
        }
    } catch (Exception $e) {
        error_log("Erro ao buscar pagamentos: " . $e->getMessage());
    }
    
    // Fallback: buscar apenas dos serviços
    try {
        $query = "SELECT COALESCE(SUM(s.valor), 0) as total_receita
                  FROM servicos_os s
                  INNER JOIN equipamentos_os e ON s.id_equipamento = e.id
                  INNER JOIN ordens_servico os ON e.id_os = os.id
                  WHERE os.data_criacao BETWEEN :data_inicio AND :data_fim
                  AND os.status = 'Concluído'";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':data_inicio', $filtroData['data_inicio']);
        $stmt->bindValue(':data_fim', $filtroData['data_fim']);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("Receita de serviços: " . $result['total_receita']);
        return $result['total_receita'];
    } catch (Exception $e) {
        error_log("Erro no fallback de receita: " . $e->getMessage());
        return 0;
    }
}

function getDespesasTotal($pdo, $filtroData) {
    try {
        $query = "SELECT COALESCE(SUM(ABS(op.valor_total)), 0) as total_despesas
                  FROM os_produto op
                  INNER JOIN ordens_servico os ON op.id_os = os.id
                  WHERE os.data_criacao BETWEEN :data_inicio AND :data_fim
                  AND os.status = 'Concluído'";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':data_inicio', $filtroData['data_inicio']);
        $stmt->bindValue(':data_fim', $filtroData['data_fim']);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("Despesas: " . $result['total_despesas']);
        return $result['total_despesas'];
        
    } catch (Exception $e) {
        error_log("Erro ao buscar despesas: " . $e->getMessage());
        return 0;
    }
}

function getDadosGraficoDespesas($pdo, $filtroData) {
    try {
        $query = "SELECT 
                    DATE_FORMAT(os.data_criacao, '%Y-%m') as mes,
                    COALESCE(SUM(ABS(op.valor_total)), 0) as despesas
                  FROM os_produto op
                  INNER JOIN ordens_servico os ON op.id_os = os.id
                  WHERE os.data_criacao BETWEEN :data_inicio AND :data_fim
                  AND os.status = 'Concluído'
                  GROUP BY DATE_FORMAT(os.data_criacao, '%Y-%m')
                  ORDER BY mes";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':data_inicio', $filtroData['data_inicio']);
        $stmt->bindValue(':data_fim', $filtroData['data_fim']);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("Dados gráfico despesas: " . json_encode($result));
        return $result;
    } catch (Exception $e) {
        error_log("Erro ao buscar dados gráfico despesas: " . $e->getMessage());
        return [];
    }
}

function getPagamentosPendentes($pdo, $filtroData = null) {
    try {
        $query = "SELECT 
                    COALESCE(SUM(
                        (SELECT COALESCE(SUM(s.valor), 0) 
                         FROM servicos_os s 
                         INNER JOIN equipamentos_os e ON s.id_equipamento = e.id 
                         WHERE e.id_os = os.id)
                        - 
                        (SELECT COALESCE(SUM(p.valor_total), 0)
                         FROM pagamento p 
                         WHERE p.id_os = os.id AND p.status = 'Concluído')
                    ), 0) as total_pendente
                  FROM ordens_servico os
                  WHERE (os.status != 'Concluído' 
                  OR EXISTS (SELECT 1 FROM pagamento p WHERE p.id_os = os.id AND p.status != 'Concluído'))";
        
        // Se um filtro de data foi fornecido, aplicar
        if ($filtroData) {
            $query .= " AND os.data_criacao BETWEEN :data_inicio AND :data_fim";
        }
        
        $stmt = $pdo->prepare($query);
        
        if ($filtroData) {
            $stmt->bindValue(':data_inicio', $filtroData['data_inicio']);
            $stmt->bindValue(':data_fim', $filtroData['data_fim']);
        }
        
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("Pagamentos pendentes: " . $result['total_pendente']);
        return max(0, $result['total_pendente']);
        
    } catch (Exception $e) {
        error_log("Erro ao buscar pagamentos pendentes: " . $e->getMessage());
        return 0;
    }
}

function getQuantidadePendentes($pdo, $filtroData = null) {
    try {
        $query = "SELECT COUNT(DISTINCT os.id) as total_pendentes
                  FROM ordens_servico os
                  WHERE (os.status != 'Concluído' 
                  OR EXISTS (SELECT 1 FROM pagamento p WHERE p.id_os = os.id AND p.status != 'Concluído'))";
        
        // Se um filtro de data foi fornecido, aplicar
        if ($filtroData) {
            $query .= " AND os.data_criacao BETWEEN :data_inicio AND :data_fim";
        }
        
        $stmt = $pdo->prepare($query);
        
        if ($filtroData) {
            $stmt->bindValue(':data_inicio', $filtroData['data_inicio']);
            $stmt->bindValue(':data_fim', $filtroData['data_fim']);
        }
        
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("Quantidade pendentes: " . $result['total_pendentes']);
        return $result['total_pendentes'];
        
    } catch (Exception $e) {
        error_log("Erro ao buscar quantidade de pendentes: " . $e->getMessage());
        return 0;
    }
}

function getDadosGraficoReceita($pdo, $filtroData) {
    try {
        // Primeiro tenta buscar da tabela de pagamentos
        $query = "SELECT 
                    DATE_FORMAT(p.data_pagamento, '%Y-%m') as mes,
                    COALESCE(SUM(p.valor_total), 0) as receita
                  FROM pagamento p
                  WHERE p.status = 'Concluído'
                  AND p.data_pagamento BETWEEN :data_inicio AND :data_fim
                  GROUP BY DATE_FORMAT(p.data_pagamento, '%Y-%m')
                  ORDER BY mes";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':data_inicio', $filtroData['data_inicio']);
        $stmt->bindValue(':data_fim', $filtroData['data_fim']);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        error_log("Dados gráfico receita (pagamentos): " . json_encode($result));
        
        if (!empty($result)) {
            return $result;
        }
    } catch (Exception $e) {
        error_log("Erro ao buscar dados gráfico receita: " . $e->getMessage());
    }
    
    try {
        // Fallback: buscar por data de criação da OS
        $query = "SELECT 
                    DATE_FORMAT(os.data_criacao, '%Y-%m') as mes,
                    COALESCE(SUM(s.valor), 0) as receita
                  FROM ordens_servico os
                  LEFT JOIN equipamentos_os e ON os.id = e.id_os
                  LEFT JOIN servicos_os s ON e.id = s.id_equipamento
                  WHERE os.data_criacao BETWEEN :data_inicio AND :data_fim
                  AND os.status = 'Concluído'
                  GROUP BY DATE_FORMAT(os.data_criacao, '%Y-%m')
                  ORDER BY mes";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':data_inicio', $filtroData['data_inicio']);
        $stmt->bindValue(':data_fim', $filtroData['data_fim']);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("Dados gráfico receita (serviços): " . json_encode($result));
        return $result;
    } catch (Exception $e) {
        error_log("Erro no fallback de gráfico receita: " . $e->getMessage());
        return [];
    }
}

function getDadosStatusPagamentos($pdo, $filtroData = null) {
    try {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN os.status = 'Concluído' THEN 1 ELSE 0 END) as concluidas,
                    SUM(CASE WHEN os.status != 'Concluído' THEN 1 ELSE 0 END) as pendentes
                  FROM ordens_servico os";
        
        // Se um filtro de data foi fornecido, aplicar
        if ($filtroData) {
            $query .= " WHERE os.data_criacao BETWEEN :data_inicio AND :data_fim";
        }
        
        $stmt = $pdo->prepare($query);
        
        if ($filtroData) {
            $stmt->bindValue(':data_inicio', $filtroData['data_inicio']);
            $stmt->bindValue(':data_fim', $filtroData['data_fim']);
        }
        
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        error_log("Status pagamentos: " . json_encode($result));
        return $result;
    } catch (Exception $e) {
        error_log("Erro ao buscar status pagamentos: " . $e->getMessage());
        return ['total' => 0, 'concluidas' => 0, 'pendentes' => 0];
    }
}

function getUltimasOrdens($pdo, $limite = 5, $filtroData = null) {
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
                  LEFT JOIN servicos_os s ON e.id = s.id_equipamento";
        
        // Se um filtro de data foi fornecido, aplicar
        if ($filtroData) {
            $query .= " WHERE os.data_criacao BETWEEN :data_inicio AND :data_fim";
        }
        
        $query .= " GROUP BY os.id
                  ORDER BY os.data_criacao DESC
                  LIMIT :limite";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        
        if ($filtroData) {
            $stmt->bindValue(':data_inicio', $filtroData['data_inicio']);
            $stmt->bindValue(':data_fim', $filtroData['data_fim']);
        }
        
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("Últimas ordens: " . json_encode($result));
        return $result;
    } catch (Exception $e) {
        error_log("Erro ao buscar últimas ordens: " . $e->getMessage());
        return [];
    }
}

// Processar parâmetros de filtro
$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'periodo';
$periodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : 30;
$mesSelecionado = isset($_GET['mes']) ? $_GET['mes'] : '';

// Processar o filtro de data
$filtroData = processarFiltroData($filtro, $periodo, $mesSelecionado);

error_log("Filtro processado: " . json_encode($filtroData));

try {
    $receitaTotal = getReceitaTotal($pdo, $filtroData);
    $despesasTotal = getDespesasTotal($pdo, $filtroData);

    // CALCULAR LUCRO LÍQUIDO
    $lucroLiquido = $receitaTotal - $despesasTotal;
    // Não forçar 0 se for negativo - mostrar valor real
    // if ($lucroLiquido < 0) {
    //     $lucroLiquido = 0;
    // }

    $pagamentosPendentes = getPagamentosPendentes($pdo, $filtroData);
    $quantidadePendentes = getQuantidadePendentes($pdo, $filtroData);
    $dadosGraficoReceita = getDadosGraficoReceita($pdo, $filtroData);
    $dadosGraficoDespesas = getDadosGraficoDespesas($pdo, $filtroData);
    $dadosStatus = getDadosStatusPagamentos($pdo, $filtroData);
    $ultimasOrdens = getUltimasOrdens($pdo, 5, $filtroData);

    $dadosDashboard = [
        'receitaTotal' => (float)$receitaTotal,
        'despesasTotal' => (float)$despesasTotal,
        'lucroLiquido' => (float)$lucroLiquido,
        'pagamentosPendentes' => (float)$pagamentosPendentes,
        'quantidadePendentes' => (int)$quantidadePendentes,
        'dadosGraficoReceita' => $dadosGraficoReceita,
        'dadosGraficoDespesas' => $dadosGraficoDespesas,
        'dadosStatus' => $dadosStatus,
        'ultimasOrdens' => $ultimasOrdens,
        'filtroData' => $filtroData,
        'sucesso' => true
    ];

    error_log("Dados retornados: " . json_encode([
        'receita' => $receitaTotal,
        'despesas' => $despesasTotal,
        'lucro' => $lucroLiquido,
        'pendentes_valor' => $pagamentosPendentes,
        'pendentes_qtd' => $quantidadePendentes
    ]));

} catch (Exception $e) {
    $dadosDashboard = [
        'sucesso' => false,
        'erro' => "Erro geral: " . $e->getMessage()
    ];
    error_log("Erro geral: " . $e->getMessage());
}

header('Content-Type: application/json');
echo json_encode($dadosDashboard);
?>