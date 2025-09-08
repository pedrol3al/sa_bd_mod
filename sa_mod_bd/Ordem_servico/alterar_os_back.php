<?php
// alterar_os_backend.php
session_start();
require_once '../Conexao/conexao.php';

// Verificar permissão do usuário
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3) {
    $_SESSION['mensagem'] = 'Acesso negado!';
    $_SESSION['tipo_mensagem'] = 'error';
    header('Location: ../Principal/main.php');
    exit();
}

// Verificar se o ID foi passado
if (!isset($_GET['id'])) {
    $_SESSION['mensagem'] = 'ID da OS não especificado!';
    $_SESSION['tipo_mensagem'] = 'error';
    header('Location: buscar_os.php');
    exit;
}

$id_os = $_GET['id'];

// Processar exclusão se solicitado
if (isset($_GET['excluir_os'])) {
    try {
        $pdo->beginTransaction();
        
        // Excluir serviços primeiro
        $sql_servicos = "DELETE servicos_os FROM servicos_os 
                         INNER JOIN equipamentos_os ON servicos_os.id_equipamento = equipamentos_os.id 
                         WHERE equipamentos_os.id_os = :id_os";
        $stmt_servicos = $pdo->prepare($sql_servicos);
        $stmt_servicos->bindParam(':id_os', $id_os);
        $stmt_servicos->execute();
        
        // Excluir equipamentos
        $sql_equipamentos = "DELETE FROM equipamentos_os WHERE id_os = :id_os";
        $stmt_equipamentos = $pdo->prepare($sql_equipamentos);
        $stmt_equipamentos->bindParam(':id_os', $id_os);
        $stmt_equipamentos->execute();
        
        // Excluir pagamentos
        $sql_pagamentos = "DELETE FROM pagamento WHERE id_os = :id_os";
        $stmt_pagamentos = $pdo->prepare($sql_pagamentos);
        $stmt_pagamentos->bindParam(':id_os', $id_os);
        $stmt_pagamentos->execute();
        
        // Excluir OS
        $sql_os = "DELETE FROM ordens_servico WHERE id = :id_os";
        $stmt_os = $pdo->prepare($sql_os);
        $stmt_os->bindParam(':id_os', $id_os);
        $stmt_os->execute();
        
        $pdo->commit();
        
        $_SESSION['mensagem'] = 'OS excluída com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        
        header('Location: buscar_os.php');
        exit;
        
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['mensagem'] = 'Erro ao excluir OS: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'error';
        header('Location: alterar_os.php?id=' . $id_os);
        exit;
    }
}

// Buscar dados da OS
try {
    $sql_os = "SELECT os.*, c.nome as cliente_nome, c.id_cliente, u.nome as tecnico_nome, u.id_usuario
               FROM ordens_servico os
               INNER JOIN cliente c ON os.id_cliente = c.id_cliente
               INNER JOIN usuario u ON os.id_usuario = u.id_usuario
               WHERE os.id = :id_os";
    
    $stmt_os = $pdo->prepare($sql_os);
    $stmt_os->bindParam(':id_os', $id_os);
    $stmt_os->execute();
    $os = $stmt_os->fetch();
    
    if (!$os) {
        $_SESSION['mensagem'] = 'OS não encontrada!';
        $_SESSION['tipo_mensagem'] = 'error';
        header('Location: buscar_os.php');
        exit;
    }
    
    // Buscar equipamentos da OS
    $sql_equipamentos = "SELECT * FROM equipamentos_os WHERE id_os = :id_os";
    $stmt_equipamentos = $pdo->prepare($sql_equipamentos);
    $stmt_equipamentos->bindParam(':id_os', $id_os);
    $stmt_equipamentos->execute();
    $equipamentos = $stmt_equipamentos->fetchAll();
    
    // Buscar serviços dos equipamentos
    $servicos_por_equipamento = [];
    foreach ($equipamentos as $equipamento) {
        $sql_servicos = "SELECT * FROM servicos_os WHERE id_equipamento = :id_equipamento";
        $stmt_servicos = $pdo->prepare($sql_servicos);
        $stmt_servicos->bindParam(':id_equipamento', $equipamento['id']);
        $stmt_servicos->execute();
        $servicos_por_equipamento[$equipamento['id']] = $stmt_servicos->fetchAll();
    }
    
    // Buscar pagamentos da OS
    $sql_pagamentos = "SELECT * FROM pagamento WHERE id_os = :id_os ORDER BY data_pagamento DESC";
    $stmt_pagamentos = $pdo->prepare($sql_pagamentos);
    $stmt_pagamentos->bindParam(':id_os', $id_os);
    $stmt_pagamentos->execute();
    $pagamentos = $stmt_pagamentos->fetchAll();
    
    // Buscar clientes para o dropdown
    $sql_clientes = "SELECT id_cliente, nome FROM cliente WHERE inativo = 0 ORDER BY nome";
    $stmt_clientes = $pdo->prepare($sql_clientes);
    $stmt_clientes->execute();
    $clientes = $stmt_clientes->fetchAll();
    
    // Buscar técnicos para o dropdown
    $sql_tecnicos = "SELECT id_usuario, nome FROM usuario WHERE id_perfil = 3 AND inativo = 0 ORDER BY nome";
    $stmt_tecnicos = $pdo->prepare($sql_tecnicos);
    $stmt_tecnicos->execute();
    $tecnicos = $stmt_tecnicos->fetchAll();
    
} catch (PDOException $e) {
    echo "Erro ao carregar OS: " . $e->getMessage();
    exit;
}

// Processar atualização
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['atualizar_os'])) {
    try {
        $id_cliente = $_POST['id_cliente'];
        $id_usuario = $_POST['id_usuario'];
        $data_termino = !empty($_POST['data_termino']) ? $_POST['data_termino'] : null;
        $status = $_POST['status'];
        $observacoes = $_POST['observacoes'];
        
        $sql_update = "UPDATE ordens_servico 
                       SET id_cliente = :id_cliente, 
                           id_usuario = :id_usuario, 
                           data_termino = :data_termino, 
                           status = :status, 
                           observacoes = :observacoes 
                       WHERE id = :id_os";
        
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':id_cliente', $id_cliente);
        $stmt_update->bindParam(':id_usuario', $id_usuario);
        $stmt_update->bindParam(':data_termino', $data_termino);
        $stmt_update->bindParam(':status', $status);
        $stmt_update->bindParam(':observacoes', $observacoes);
        $stmt_update->bindParam(':id_os', $id_os);
        
        $stmt_update->execute();
        
        $_SESSION['mensagem'] = 'OS atualizada com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        
        header('Location: buscar_os.php');
        exit();
        
    } catch (Exception $e) {
        $_SESSION['mensagem'] = 'Erro ao atualizar OS: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'error';
    }
}
?>