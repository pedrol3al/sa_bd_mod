<?php
session_start();
require_once '../Conexao/conexao.php';
require_once '../Financas/finance_functions.php';

// Verifica se o usuário tem permissão
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 4) {
    $_SESSION['mensagem'] = 'Acesso negado!';
    $_SESSION['tipo_mensagem'] = 'error'; 
    header('Location: ../Principal/main.php');
    exit();
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
        
        if ($valor_total <= 0) {
            throw new Exception("O valor do pagamento deve ser maior que zero!");
        }
        
        // Verificar se a OS existe
        $sql_verifica_os = "SELECT id FROM ordens_servico WHERE id = :id_os";
        $stmt_verifica_os = $pdo->prepare($sql_verifica_os);
        $stmt_verifica_os->bindParam(':id_os', $id_os);
        $stmt_verifica_os->execute();
        
        if ($stmt_verifica_os->rowCount() == 0) {
            throw new Exception("Ordem de Serviço não encontrada!");
        }
        
        // Calcular valores totais usando as novas funções
        $valor_total_os = getValorTotalOS($pdo, $id_os);
        $valor_pago = getValorPagoOS($pdo, $id_os);
        
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
        
        // Atualizar status da OS se necessário
        atualizarStatusOS($pdo, $id_os);
        
        $_SESSION['mensagem'] = 'Pagamento registrado com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success'; 
        header('Location: pagamento_os.php');
        exit;
        
    } catch (Exception $e) {
        $_SESSION['mensagem'] = 'Erro ao registrar pagamento: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'error'; // Alterado para 'error'
        header('Location: pagamento_os.php');
        exit;
    }
}
?>