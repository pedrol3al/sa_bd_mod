<?php
// Habilitar exibição de erros para debug (útil durante desenvolvimento)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia a sessão para manter dados do usuário
session_start();

// Inclui arquivo de conexão com o banco de dados
require_once '../Conexao/conexao.php';

// Verificar se a conexão foi estabelecida corretamente
if (!isset($pdo) || !$pdo) {
    echo json_encode([
        'sucesso' => false,
        'erro' => "Falha na conexão com o banco de dados"
    ]);
    exit;
}

// Função para calcular a receita total em um período específico
function getReceitaTotal($pdo, $periodo)
{
    try {
        // Query principal: busca receita de pagamentos concluídos
        $query = $query = "SELECT COALESCE(SUM(p.valor_total), 0) as total_receita
          FROM pagamento p
          INNER JOIN ordens_servico os ON p.id_os = os.id
          WHERE p.status = 'Concluído'
          AND p.data_pagamento >= DATE_SUB(NOW(), INTERVAL :periodo DAY)";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se encontrou receita, retorna o valor
        if ($result['total_receita'] > 0) {
            return $result['total_receita'];
        }
    } catch (Exception $e) {
        // Log de erro para debug
        error_log("Erro ao buscar pagamentos: " . $e->getMessage());
    }

    // Fallback: busca receita dos serviços caso a query principal falhe
    try {
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
    } catch (Exception $e) {
        error_log("Erro no fallback de receita: " . $e->getMessage());
        return 0; // Retorna 0 em caso de erro
    }
}

// Função para calcular despesas totais em um período
function getDespesasTotal($pdo, $periodo)
{
    // Configura timezone para garantir datas corretas
    $timezone = new DateTimeZone('America/Sao_Paulo');
    $dataAtual = new DateTime('now', $timezone);

    try {
        // Busca despesas totais (valor absoluto) de produtos usados em OS concluídas
        $query = "SELECT COALESCE(SUM(ABS(op.valor_total)), 0) as total_despesas
                  FROM os_produto op
                  INNER JOIN ordens_servico os ON op.id_os = os.id
                  WHERE os.data_criacao >= DATE_SUB(:data_atual, INTERVAL :periodo DAY)
                  AND os.status = 'Concluído'";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
        $stmt->bindValue(':data_atual', $dataAtual->format('Y-m-d H:i:s'));
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_despesas'];

    } catch (Exception $e) {
        error_log("Erro ao buscar despesas: " . $e->getMessage());
        return 0;
    }
}

// Função para obter dados de despesas por mês para gráfico
function getDadosGraficoDespesas($pdo, $periodo)
{
    try {
        $timezone = new DateTimeZone('America/Sao_Paulo');
        $dataAtual = new DateTime('now', $timezone);

        // Agrupa despesas por mês para exibição em gráfico
        $query = "SELECT 
                    DATE_FORMAT(os.data_criacao, '%Y-%m') as mes,
                    COALESCE(SUM(ABS(op.valor_total)), 0) as despesas
                  FROM os_produto op
                  INNER JOIN ordens_servico os ON op.id_os = os.id
                  WHERE os.data_criacao >= DATE_SUB(:data_atual, INTERVAL :periodo DAY)
                  AND os.status = 'Concluído'
                  GROUP BY DATE_FORMAT(os.data_criacao, '%Y-%m')
                  ORDER BY mes";

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':periodo', $periodo, PDO::PARAM_INT);
        $stmt->bindValue(':data_atual', $dataAtual->format('Y-m-d H:i:s'));
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Erro ao buscar dados gráfico despesas: " . $e->getMessage());
        return [];
    }
}

// Função para calcular pagamentos pendentes (não concluídos)
function getPagamentosPendentes($pdo) {
    try {
        // Calcula valor pendente: soma dos serviços menos pagamentos já realizados
        $query = "SELECT 
                    COALESCE(SUM(
                        (SELECT COALESCE(SUM(s.valor), 0) 
                         FROM servicos_os s 
                         INNER JOIN equipamentos_os e ON s.id_equipamento = e.id 
                         WHERE e.id_os = os.id)
                        - 
                        (SELECT COALESCE(SUM(p.valor_total), 0)  -- CORRIGIDO
                         FROM pagamento p 
                         WHERE p.id_os = os.id AND p.status = 'Concluído')
                    ), 0) as total_pendente
                  FROM ordens_servico os
                  WHERE os.status != 'Concluído' 
                  OR EXISTS (SELECT 1 FROM pagamento p WHERE p.id_os = os.id AND p.status != 'Concluído')";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return max(0, $result['total_pendente']); // Garante que não seja negativo
        
    } catch (Exception $e) {
        error_log("Erro ao buscar pagamentos pendentes: " . $e->getMessage());
        return 0;
    }
}

// Função para contar quantidade de ordens pendentes
function getQuantidadePendentes($pdo)
{
    try {
        // Conta ordens de serviço que não estão concluídas ou têm pagamentos pendentes
        $query = "SELECT COUNT(DISTINCT os.id) as total_pendentes
                  FROM ordens_servico os
                  WHERE os.status != 'Concluído' 
                  OR EXISTS (SELECT 1 FROM pagamento p WHERE p.id_os = os.id AND p.status != 'Concluído')";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_pendentes'];

    } catch (Exception $e) {
        error_log("Erro ao buscar quantidade de pendentes: " . $e->getMessage());
        return 0;
    }
}

// Função para obter dados de receita por mês para gráfico
function getDadosGraficoReceita($pdo, $periodo)
{
    try {
        // Agrupa receita por mês a partir dos pagamentos
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

        if (!empty($result)) {
            return $result;
        }
    } catch (Exception $e) {
        error_log("Erro ao buscar dados gráfico receita: " . $e->getMessage());
    }

    // Fallback: busca receita dos serviços caso a query principal falhe
    try {
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
    } catch (Exception $e) {
        error_log("Erro no fallback de gráfico receita: " . $e->getMessage());
        return [];
    }
}

// Função para obter estatísticas de status dos pagamentos
function getDadosStatusPagamentos($pdo)
{
    try {
        // Conta total de ordens, concluídas e pendentes
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN os.status = 'Concluído' THEN 1 ELSE 0 END) as concluidas,
                    SUM(CASE WHEN os.status != 'Concluído' THEN 1 ELSE 0 END) as pendentes
                  FROM ordens_servico os";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Erro ao buscar status pagamentos: " . $e->getMessage());
        return ['total' => 0, 'concluidas' => 0, 'pendentes' => 0];
    }
}

// Função para buscar as últimas ordens de serviço
function getUltimasOrdens($pdo, $limite = 5)
{
    try {
        // Busca últimas ordens com informações do cliente e status de pagamento
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
        error_log("Erro ao buscar últimas ordens: " . $e->getMessage());

        // Fallback: versão simplificada da query
        try {
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
        } catch (Exception $e2) {
            error_log("Erro no fallback de últimas ordens: " . $e2->getMessage());
            return [];
        }
    }
}

// Processamento principal: busca dados com período informado
$periodo = isset($_GET['periodo']) ? intval($_GET['periodo']) : 30; // Padrão: 30 dias

try {
    // Executa todas as funções para coletar dados do dashboard
    $receitaTotal = getReceitaTotal($pdo, $periodo);
    $despesasTotal = getDespesasTotal($pdo, $periodo);

    // CALCULAR LUCRO LÍQUIDO - SE FOR NEGATIVO, DEFINIR COMO 0
    $lucroLiquido = $receitaTotal - $despesasTotal;
    if ($lucroLiquido < 0) {
        $lucroLiquido = 0;
    }

    $pagamentosPendentes = getPagamentosPendentes($pdo);
    $quantidadePendentes = getQuantidadePendentes($pdo);
    $dadosGraficoReceita = getDadosGraficoReceita($pdo, $periodo);
    $dadosGraficoDespesas = getDadosGraficoDespesas($pdo, $periodo);
    $dadosStatus = getDadosStatusPagamentos($pdo);
    $ultimasOrdens = getUltimasOrdens($pdo, 5);

    // Monta array com todos os dados para retorno JSON
    $dadosDashboard = [
        'receitaTotal' => $receitaTotal,
        'despesasTotal' => $despesasTotal,
        'lucroLiquido' => $lucroLiquido,
        'pagamentosPendentes' => $pagamentosPendentes,
        'quantidadePendentes' => $quantidadePendentes,
        'dadosGraficoReceita' => $dadosGraficoReceita,
        'dadosGraficoDespesas' => $dadosGraficoDespesas,
        'dadosStatus' => $dadosStatus,
        'ultimasOrdens' => $ultimasOrdens,
        'periodo' => $periodo,
        'sucesso' => true
    ];

} catch (Exception $e) {
    // Em caso de erro geral, retorna mensagem de erro
    $dadosDashboard = [
        'sucesso' => false,
        'erro' => "Erro geral: " . $e->getMessage()
    ];
}

// Define cabeçalho para resposta JSON
header('Content-Type: application/json');
echo json_encode($dadosDashboard); // Retorna dados em formato JSON
?>