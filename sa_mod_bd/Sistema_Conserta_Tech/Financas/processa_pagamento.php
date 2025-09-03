<?php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    $_SESSION['mensagem'] = 'Acesso negado!';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Validar dados recebidos
        $id_os = filter_input(INPUT_POST, 'id_os', FILTER_VALIDATE_INT);
        $valor_total = filter_input(INPUT_POST, 'valor_total', FILTER_VALIDATE_FLOAT);
        $data_pagamento = $_POST['data_pagamento'];
        $frm_pagamento = $_POST['frm_pagamento'];
        $status = $_POST['status'];
        
        if (!$id_os || !$valor_total || !$data_pagamento || !$frm_pagamento || !$status) {
            throw new Exception("Dados inválidos! Preencha todos os campos obrigatórios.");
        }
        
        // Verificar se a OS existe
        $sql_verifica_os = "SELECT id FROM ordens_servico WHERE id = :id_os";
        $stmt_verifica_os = $pdo->prepare($sql_verifica_os);
        $stmt_verifica_os->bindParam(':id_os', $id_os);
        $stmt_verifica_os->execute();
        
        if ($stmt_verifica_os->rowCount() == 0) {
            throw new Exception("Ordem de Serviço não encontrada!");
        }
        
        // **CORREÇÃO: Calcular valores totais ANTES de inserir o novo pagamento**
        $sql_valores = "SELECT 
            COALESCE(SUM(s.valor), 0) as valor_total_os
        FROM ordens_servico os
        LEFT JOIN equipamentos_os e ON os.id = e.id_os
        LEFT JOIN servicos_os s ON e.id = s.id_equipamento
        WHERE os.id = :id_os
        GROUP BY os.id";
        
        $stmt_valores = $pdo->prepare($sql_valores);
        $stmt_valores->bindParam(':id_os', $id_os);
        $stmt_valores->execute();
        $valores_os = $stmt_valores->fetch();
        
        $valor_total_os = $valores_os['valor_total_os'];
        
        // **CORREÇÃO: Calcular valor já pago separadamente (excluindo o pagamento atual)**
        $sql_valor_pago = "SELECT COALESCE(SUM(valor_total), 0) as valor_pago 
                          FROM pagamento 
                          WHERE id_os = :id_os";
        
        $stmt_valor_pago = $pdo->prepare($sql_valor_pago);
        $stmt_valor_pago->bindParam(':id_os', $id_os);
        $stmt_valor_pago->execute();
        $valores_pago = $stmt_valor_pago->fetch();
        
        $valor_pago = $valores_pago['valor_pago'];
        
        // Verificar se o pagamento não excede o valor total
        if (($valor_pago + $valor_total) > $valor_total_os) {
            throw new Exception("O valor do pagamento excede o valor total da OS!");
        }
        
        // Inserir pagamento
        $sql_pagamento = "INSERT INTO pagamento (
            id_os, valor_total, frm_pagamento, data_pagamento, status
        ) VALUES (
            :id_os, :valor_total, :frm_pagamento, :data_pagamento, :status
        )";
        
        $stmt_pagamento = $pdo->prepare($sql_pagamento);
        $stmt_pagamento->bindParam(':id_os', $id_os);
        $stmt_pagamento->bindParam(':valor_total', $valor_total);
        $stmt_pagamento->bindParam(':frm_pagamento', $frm_pagamento);
        $stmt_pagamento->bindParam(':data_pagamento', $data_pagamento);
        $stmt_pagamento->bindParam(':status', $status);
        
        $stmt_pagamento->execute();
        
        // Verificar se a OS foi totalmente paga e atualizar status se necessário
        $novo_valor_pago = $valor_pago + $valor_total;
        
        if ($novo_valor_pago >= $valor_total_os) {
            $sql_atualiza_status = "UPDATE ordens_servico SET status = 'Concluído' WHERE id = :id_os";
            $stmt_atualiza_status = $pdo->prepare($sql_atualiza_status);
            $stmt_atualiza_status->bindParam(':id_os', $id_os);
            $stmt_atualiza_status->execute();
        }
        
        $_SESSION['mensagem'] = 'Pagamento registrado com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        header('Location: pagamento_os.php');
        exit;
        
    } catch (Exception $e) {
        $_SESSION['mensagem'] = 'Erro ao registrar pagamento: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'danger';
        header('Location: pagamento_os.php');
        exit;
    }
} else {
    $_SESSION['mensagem'] = 'Método de requisição inválido!';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: pagamento_os.php');
    exit;
}
?>