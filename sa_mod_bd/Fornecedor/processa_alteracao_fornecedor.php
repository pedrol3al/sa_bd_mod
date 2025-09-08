<?php
session_start();
require_once '../Conexao/conexao.php';

// Processar exclusão do fornecedor
if (isset($_GET['excluir_fornecedor']) && isset($_GET['id'])) {
    $id_fornecedor = intval($_GET['id']);
    
    try {
        $sql = "DELETE FROM fornecedor WHERE id_fornecedor = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_fornecedor, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            header("Location: buscar_fornecedor.php?msg=success&text=Fornecedor excluído com sucesso!");
            exit;
        } else {
            header("Location: buscar_fornecedor.php?msg=error&text=Erro ao excluir fornecedor!");
            exit;
        }
    } catch (Exception $e) {
        header("Location: buscar_fornecedor.php?msg=error&text=Erro ao excluir fornecedor: " . urlencode($e->getMessage()));
        exit;
    }
}

// Verifica se o formulário foi enviado para atualização
if (isset($_POST['atualizar_fornecedor'])) {
    try {
        $id = intval($_POST['id_fornecedor']);

        $sql = "UPDATE fornecedor SET 
                    razao_social = :razao_social,
                    email = :email,
                    cnpj = :cnpj,
                    data_fundacao = :data_fundacao,
                    produto_fornecido = :produto_fornecido,
                    cep = :cep,
                    logradouro = :logradouro,
                    tipo = :tipo,
                    numero = :numero,
                    complemento = :complemento,
                    bairro = :bairro,
                    cidade = :cidade,
                    uf = :uf,
                    telefone = :telefone,
                    observacoes = :observacoes
                WHERE id_fornecedor = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':razao_social' => $_POST['razao_social'],
            ':email' => $_POST['email'],
            ':cnpj' => $_POST['cnpj'],
            ':data_fundacao' => $_POST['data_fundacao'],
            ':produto_fornecido' => $_POST['produto_fornecido'],
            ':cep' => $_POST['cep'],
            ':logradouro' => $_POST['logradouro'],
            ':tipo' => $_POST['tipo'],
            ':numero' => $_POST['numero'],
            ':complemento' => $_POST['complemento'],
            ':bairro' => $_POST['bairro'],
            ':cidade' => $_POST['cidade'],
            ':uf' => $_POST['uf'],
            ':telefone' => $_POST['telefone'],
            ':observacoes' => $_POST['observacoes'],
            ':id' => $id
        ]);

        // Redireciona para a página de listagem com mensagem de sucesso
        header("Location: buscar_fornecedor.php?msg=success&text=Fornecedor atualizado com sucesso!");
        exit;

    } catch (Exception $e) {
        // Redireciona com mensagem de erro
        header("Location: alterar_fornecedor.php?id=" . $id . "&error=" . urlencode("Erro ao atualizar fornecedor: " . $e->getMessage()));
        exit;
    }
}
?>