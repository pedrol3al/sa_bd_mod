<?php
// ARQUIVO: finance_functions.php
// Funções financeiras centralizadas para garantir consistência

function getReceitaTotal($pdo, $periodo) {
    try {
        $data_inicio = date('Y-m-d', strtotime("-$periodo days"));
        
        $query = "
            SELECT COALESCE(SUM(s.valor), 0) as total
            FROM servicos_os s
            INNER JOIN equipamentos_os e ON s.id_equipamento = e.id
            INNER JOIN ordens_servico os ON e.id_os = os.id
            WHERE os.data_criacao >= :data_inicio
        ";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':data_inicio', $data_inicio);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return floatval($row['total']);
    } catch (Exception $e) {
        error_log("Erro getReceitaTotal: " . $e->getMessage());
        return 0;
    }
}

function getDespesasTotal($pdo, $periodo) {
    try {
        $data_inicio = date('Y-m-d', strtotime("-$periodo days"));
        
        // Soma o custo dos produtos utilizados nas OS
        $query = "
            SELECT COALESCE(SUM(op.quantidade * p.preco_custo), 0) as total
            FROM os_produto op
            INNER JOIN produto p ON op.id_produto = p.id_produto
            INNER JOIN ordens_servico os ON op.id_os = os.id
            WHERE os.data_criacao >= :data_inicio
        ";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':data_inicio', $data_inicio);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return floatval($row['total']);
    } catch (Exception $e) {
        error_log("Erro getDespesasTotal: " . $e->getMessage());
        return 0;
    }
}

function getPagamentosPendentes($pdo) {
    try {
        $query = "SELECT COALESCE(SUM(valor_total), 0) as total 
                  FROM pagamento 
                  WHERE status != 'Concluído'";
        $stmt = $pdo->query($query);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return floatval($row['total']);
    } catch (Exception $e) {
        error_log("Erro getPagamentosPendentes: " . $e->getMessage());
        return 0;
    }
}

function getValorTotalOS($pdo, $id_os) {
    try {
        $query = "SELECT COALESCE(SUM(valor), 0) as total 
                  FROM servicos_os s
                  INNER JOIN equipamentos_os e ON s.id_equipamento = e.id
                  WHERE e.id_os = :id_os";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_os', $id_os);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return floatval($row['total']);
    } catch (Exception $e) {
        error_log("Erro getValorTotalOS: " . $e->getMessage());
        return 0;
    }
}

function getValorPagoOS($pdo, $id_os) {
    try {
        $query = "SELECT COALESCE(SUM(valor_total), 0) as total 
                  FROM pagamento 
                  WHERE id_os = :id_os AND status = 'Concluído'";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_os', $id_os);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return floatval($row['total']);
    } catch (Exception $e) {
        error_log("Erro getValorPagoOS: " . $e->getMessage());
        return 0;
    }
}

function atualizarStatusOS($pdo, $id_os) {
    try {
        $valor_total = getValorTotalOS($pdo, $id_os);
        $valor_pago = getValorPagoOS($pdo, $id_os);
        
        $novo_status = ($valor_pago >= $valor_total) ? 'Concluído' : 'Em andamento';
        
        $query = "UPDATE ordens_servico SET status = :status WHERE id = :id_os";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':status', $novo_status);
        $stmt->bindParam(':id_os', $id_os);
        $stmt->execute();
        
        return true;
    } catch (Exception $e) {
        error_log("Erro atualizarStatusOS: " . $e->getMessage());
        return false;
    }
}
?>