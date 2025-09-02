<?php
// Reporta erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('../Conexao/conexao.php');

// Verifica perfil de administrador
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] != 1) {
    die("Acesso Negado");
}

try {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $pdo->beginTransaction(); // Inicia transação

        // Dados do formulário
        $idUsuario = $_POST['id_usuario'];
        $nomeProduto = $_POST['nome_peca'];
        $idFornecedor = $_POST['id_fornecedor'];
        $dataCadastro = $_POST['cadPeca'];
        $quantidade = $_POST['quantidade'];
        $valorUnit = $_POST['valor_unit'];
        $descricao = $_POST['descricao'];

        // ---------- Verifica se o usuário existe ----------
        $sqlCheckUsuario = "SELECT id_usuario FROM usuario WHERE id_usuario = :id_usuario";
        $stmtUsuario = $pdo->prepare($sqlCheckUsuario);
        $stmtUsuario->bindParam(':id_usuario', $idUsuario);
        $stmtUsuario->execute();

        if ($stmtUsuario->rowCount() == 0) {
            throw new Exception("Usuário não existe!");
        }

        // ---------- Verifica se o fornecedor existe ----------
        $sqlCheckFornecedor = "SELECT id_fornecedor FROM fornecedor WHERE id_fornecedor = :id_fornecedor";
        $stmtFornecedor = $pdo->prepare($sqlCheckFornecedor);
        $stmtFornecedor->bindParam(':id_fornecedor', $idFornecedor);
        $stmtFornecedor->execute();

        if ($stmtFornecedor->rowCount() == 0) {
            throw new Exception("Fornecedor não existe! Cadastre o fornecedor antes.");
        }

        // ---------- Verifica se o produto já existe ----------
        $sqlCheckProduto = "SELECT id_produto FROM produto WHERE nome = :nome AND id_usuario = :id_usuario";
        $stmtCheckProduto = $pdo->prepare($sqlCheckProduto);
        $stmtCheckProduto->bindParam(':nome', $nomeProduto);
        $stmtCheckProduto->bindParam(':id_usuario', $idUsuario);
        $stmtCheckProduto->execute();

        if ($stmtCheckProduto->rowCount() > 0) {
            $idProduto = $stmtCheckProduto->fetchColumn();
        } else {
            // Cria o produto
            $sqlProduto = "INSERT INTO produto (nome, id_usuario) VALUES (:nome, :id_usuario)";
            $stmtProduto = $pdo->prepare($sqlProduto);
            $stmtProduto->bindParam(':nome', $nomeProduto);
            $stmtProduto->bindParam(':id_usuario', $idUsuario);
            $stmtProduto->execute();
            $idProduto = $pdo->lastInsertId();
        }

        // ---------- Inserção no estoque ----------
        $sqlEstoque = "INSERT INTO estoque 
            (id_produto, id_fornecedor, data_cadastro, quantidade, valor_unitario, descricao)
            VALUES (:id_produto, :id_fornecedor, :data_cadastro, :quantidade, :valor_unitario, :descricao)";
        $stmtEstoque = $pdo->prepare($sqlEstoque);
        $stmtEstoque->bindParam(':id_produto', $idProduto);
        $stmtEstoque->bindParam(':id_fornecedor', $idFornecedor);
        $stmtEstoque->bindParam(':data_cadastro', $dataCadastro);
        $stmtEstoque->bindParam(':quantidade', $quantidade);
        $stmtEstoque->bindParam(':valor_unitario', $valorUnit);
        $stmtEstoque->bindParam(':descricao', $descricao);
        $stmtEstoque->execute();

        $pdo->commit(); // Confirma transação

        echo "<script>alert('Peça cadastrada com sucesso!'); window.location.href='cadastrar_estoque.php';</script>";

    }
} catch (Exception $e) {
    $pdo->rollBack(); // Desfaz transação
    echo "Erro no cadastro: " . $e->getMessage();
}
?>
