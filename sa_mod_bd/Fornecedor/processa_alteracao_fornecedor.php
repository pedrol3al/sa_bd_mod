<?php
session_start();
require_once '../Conexao/conexao.php';

// Verifica se o formulário foi enviado
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

        // Redireciona para a página de listagem ou sucesso
        header("Location: buscar_fornecedor.php?success=1");
        exit;

    } catch (Exception $e) {
        // Mostra erro na mesma página
        $error_message = "Erro ao atualizar fornecedor: " . $e->getMessage();
    }
}
?>
