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
        // Iniciar transação
        $pdo->beginTransaction();

        // 1. Inserir a ordem de serviço principal
        $id_cliente = $_POST['id_cliente'];
        $id_usuario = $_POST['id_usuario'];
        $data_termino = !empty($_POST['data_termino']) ? $_POST['data_termino'] : null;
        $status = $_POST['status'];
        $observacoes = $_POST['observacoes'];

        $sql_os = "INSERT INTO ordens_servico (
            id_cliente, id_usuario, data_termino, status, observacoes
        ) VALUES (
            :id_cliente, :id_usuario, :data_termino, :status, :observacoes
        )";

        $stmt_os = $pdo->prepare($sql_os);
        $stmt_os->bindParam(':id_cliente', $id_cliente);
        $stmt_os->bindParam(':id_usuario', $id_usuario);
        $stmt_os->bindParam(':data_termino', $data_termino);
        $stmt_os->bindParam(':status', $status);
        $stmt_os->bindParam(':observacoes', $observacoes);
        
        $stmt_os->execute();
        $id_os = $pdo->lastInsertId();

        // 2. Inserir os equipamentos
        if (isset($_POST['equipamentos']) && is_array($_POST['equipamentos'])) {
            $sql_equipamento = "INSERT INTO equipamentos_os (
                id_os, fabricante, modelo, num_serie, num_aparelho, defeito_reclamado, condicao
            ) VALUES (
                :id_os, :fabricante, :modelo, :num_serie, :num_aparelho, :defeito_reclamado, :condicao
            )";

            $sql_servico = "INSERT INTO servicos_os (
                id_equipamento, tipo_servico, descricao, valor
            ) VALUES (
                :id_equipamento, :tipo_servico, :descricao, :valor
            )";

            $stmt_equipamento = $pdo->prepare($sql_equipamento);
            $stmt_servico = $pdo->prepare($sql_servico);

            foreach ($_POST['equipamentos'] as $equipamento) {
                // Inserir equipamento
                $stmt_equipamento->bindParam(':id_os', $id_os);
                $stmt_equipamento->bindParam(':fabricante', $equipamento['fabricante']);
                $stmt_equipamento->bindParam(':modelo', $equipamento['modelo']);
                $stmt_equipamento->bindParam(':num_serie', $equipamento['num_serie']);
                $stmt_equipamento->bindParam(':num_aparelho', $equipamento['num_aparelho']);
                $stmt_equipamento->bindParam(':defeito_reclamado', $equipamento['defeito_reclamado']);
                $stmt_equipamento->bindParam(':condicao', $equipamento['condicao']);
                
                $stmt_equipamento->execute();
                $id_equipamento = $pdo->lastInsertId();

                // Inserir serviços deste equipamento
                if (isset($equipamento['servicos']) && is_array($equipamento['servicos'])) {
                    foreach ($equipamento['servicos'] as $servico) {
                        if (!empty($servico['tipo_servico']) && !empty($servico['valor'])) {
                            $stmt_servico->bindParam(':id_equipamento', $id_equipamento);
                            $stmt_servico->bindParam(':tipo_servico', $servico['tipo_servico']);
                            $stmt_servico->bindParam(':descricao', $servico['descricao']);
                            $stmt_servico->bindParam(':valor', $servico['valor']);
                            
                            $stmt_servico->execute();
                        }
                    }
                }
            }
        }

        // Commit da transação
        $pdo->commit();

        // Redirecionar com mensagem de sucesso
        echo "<script>
        alert('Ordem de serviço cadastrada com sucesso!');
        window.location.href = 'os.php';
    </script>";

    } catch (Exception $e) {
        // Rollback em caso de erro
        $pdo->rollBack();
        
        $_SESSION['mensagem'] = 'Erro ao cadastrar ordem de serviço: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'danger';
        header('Location: os.php');
        exit;
    }
} else {
    $_SESSION['mensagem'] = 'Método de requisição inválido!';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: os.php');
    exit;
}
?>